function [tsig, kbeg, kend] = trimit(yf,fs)
%  This function trims off the begining and ending parts of this files
%  of the input signal "Y" that is not part of the main utterance.  The
%  sampling frequecy "FS" is also a required input.
%
%    [tsig, kbeg, kend] = trimit(y,fs)
%
%  Output vector 'TSIG' is the trimed signal.  The detect indeces in the
%  orignal vector "Y" for the begining and ending point are also passed to
%  the output.
%
%   written by Kevin D Donohue (donohue@engr.uky.edu) April 2017

% modified by Nathan Thomas, April 2017
% - changed threshold from 6*noslev to 3*noslev (successfully clipped most of 'y' and 'n' files
% - added test for white noise
% - added test for colored noise/repeating sound

%  Envelope processing to smoothing out
[bf,af] = butter(4, 2*30/fs);
temp_max = max(yf);
if temp_max < .025 % TEST FOR VERY LOW POWER (white noise)
    tsig = yf;
    kbeg = 1;
    kend = length(yf);
else
    % Compute signal envelope
    envyf = abs(hilbert(yf));
    % Estimate noise level using segments ends
    noslevb = mean(envyf(1:fix(fs*.25)));  %  Beginging
    nosleve = mean(envyf(end-fix(fs*.25):end));  % Ending
    noslev = min([noslevb, nosleve]);  % Take smallest one
    leng = length(envyf);  %  Find signal length
    lenv = filtfilt(bf,af,envyf);  % Smooth out envelope to remove short nulls
    %  Find max peak and consider it part of the signal
    [sigmax, mxindx] = max(lenv);
    %  find begining point of utterance by moving backwards from max
    %  point and looks for a level drop into the noise floor
    kbeg = mxindx(1);  % Index of max level
    sigval = lenv(kbeg);  % Envelope value at max level
    %  Keep decrementing until level falls below noise threshold
    while kbeg > 1 && sigval > 3*noslev
        kbeg = kbeg-1;
        sigval = lenv(kbeg);
    end
    %  Find ending point of utterance by incrementing from max
    %  point and look for a level that drops into the noise floor
    kend = mxindx(1); %  Reset index of max level
    sigval = lenv(kend); %  Rest max value at index
    % Keep going until it falls below noise threshold
    while kend < leng && sigval > 3*noslev
        kend = kend+1;
        sigval = lenv(kend);
    end
    %  If segment is less than 200 ms, something bad likely happened.
    %  So extend segment 100 ms from each end point and hope for the best
    if kend-kbeg < .2*fs
        kend = kend + .1*fs;
        kbeg = kbeg - .1*fs;
    end
         
    % TEST FOR REPEATING SIGNAL (colored noise/repeating sound)
    % Option 1 - extract more of the desired signal
    frnt_max_vec = find(lenv(1:kbeg) >= sigmax*.4);
    bck_max_vec = find(lenv(kend:end) >= sigmax*.4);
    if length(frnt_max_vec) >= 1
        kbeg = frnt_max_vec(1);
    end
    if length(bck_max_vec) >= 1
        kend = kend + bck_max_vec(end) -1;
    end

    % Option 2 - replace entire signal
%     frnt_max = max(lenv(1:kbeg));
%     bck_max = max(lenv(kend:end));
%     if frnt_max >= sigmax*.4 || bck_max >= sigmax*.4
%         kbeg = 1;
%         kend = length(yf);
%     end

    % Extract segment
    tsig = yf(kbeg:kend);
end