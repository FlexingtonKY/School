function HD = danfilt(freq,amp,fs)
%{





%}

%Using the transfer function H(z)=K/(1-2cos(alpha)z^(-1)+z^(-2))
%or rewritten as (z^2)*K/((z^2)-2z*cos(alpha)+1)
%or even y[n]=2cos(alpha)y[n-1]-y[n-2]+Kx[n]



%alpha controls the frequency of oscillation and sampling frequency by
alpha=((2*pi.*freq)/fs);

%K scales the input to control the amplitude of oscillations
K = amp.*sin(alpha);


% the specified frequencies and corresponding amplitudes,
% relative to the specified sampling frequency.
%
%
% INPUTS
%   freqs -> vector containing desired frequencies
%   amps  -> vector containing desired amplitudes of frequencies in 'freqs'
%   fs    -> desired sampling frequency
%
% OUTPUTS
%   a     -> the denominators of the resulting transfer function
%   b     -> the numerator of the resulting transfer function
%
% EXAMPLE
%  create a TF who's impulse response resonates at 10Hz and 20Hz
%  where the 20Hz wave has twice the amplitude, sampled at 8kHz:
%
%  >> [a,b] = digosc( [10 20], [1 2], 8000); 


nfreqs=length(freq); % number of frequencies we are working with

% vector representing coeffecients for normalizing the calculation of frequencies and amplitudes
alphas=(2*pi.*freq)/fs;

% where the TF of the digital oscillator is
% (k*z^2) / (z^2 - 2*cos(alpha)*z + 1)

bs=[]; % vector to hold numerators
counter=1;
for n=amp % iterate through each specified amplitude
    bs=[bs; alphas(counter)*n 0 0]; % multiply coefficient for z^2 term by desired amplitude
    counter=counter+1;
end

as=[]; % vector to hold denominators
for n=alphas
    % create denominators based on calculated alpha values
    as=[as; 1 -2*cos(n) 1];
end

dfilts = []; % vector to hold digital filter representations
for n=1:nfreqs % convert b/a num/denom coeffs to dfilt objects
   % build vector of direct form 1 representations
   dfilts=[dfilts, dfilt.df1(bs(n,1:end), as(n,1:end))]; 
end

% parallelize the individual transfer functions
fdf=dfilt.parallel(dfilts);

% extract the state space variables of the parallelized TFs
[A,B,C,D]=fdf.ss;

% use ss2tf to convert to one TF with unified numerators and denominators
[NUM,DEN]=ss2tf(A, B, C, D);

HD = [NUM;DEN];

