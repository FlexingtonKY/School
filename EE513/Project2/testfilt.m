%% TESTBENCH
%Author:Daniel Palmer
%EE513 || 2/15/20


%test values for sampling frequency,frequency,and amplitude.
%vector lengths must match
fs = 16000;
freq = [100 500 1000 2500 4000];
amp = [1 1 1 .5 2];

%pulse was created based off specifications on project 2. Changed ...
%it to a row vector while I was debugging some things and just left it.
pulse =[1, zeros(1,2*fs-1)];

%get the coeff. using created matlab function
HD = danfilt1(freq,amp,fs);
%filter signal. b=H(1,:), a=H(2,:)
fsig=filter(HD(1,:),HD(2,:),pulse);
%take to fft for frequency domain
sigfft= fft(fsig);
%amplitudes were off by a scale of the fs, so I divided by fs to get ...
%amplitude values that I specified in the beginning
sigfft= sigfft/(fs);
f_ax = fs*[0:length(sigfft)-1]/length(sigfft);

%I think the semilog plot looks better than just normal plot. I limit ...
%the signal since it repeates at the tail end of the sampling frequency...
%so i limit based off nyquist theory
plot((f_ax),abs(sigfft))
%semilogx(f_ax,abs(sigfft));
xlim([0 fs/2]);
xlabel("Frequency Hz");
ylabel("Amplitude");
%freqz(fsig)
