%{
P3main.m
*for some reason some .wav files transpose my matrix, i have the 
issue commented in my doc file*

EE513 Project 3
Written by Daniel Palmer, referenced modules written
by Kevin D. Donohue. This file is just the main function
which calls the windowing function that performs the signal 
alteration. Use this function to modify the LPC parameters (lpcpole),
shift value (shiftval), and window length (wind). In the end,
this function will plot the original unaltered sound clip with a 
spectrogram, along with the altered sound clip and its spectrogram.

Inputs:
    -takes a wav file
    -lpcpole : LPC order
    -shiftval : variable to shift angle of formant
    -wind : window size
Output:
    -spectograms of altered and unaltered sound clips

Notes what worked and what didnt can be found in more detail
in the word document.
%}




[y,fs] = audioread('man4_take1.wav');  %  Read in wavefile
y = resample(y,8000,fs);%  Preprocessoing
fs=8000;

%alterable parameters
wind=.1;
wlen = round(fs*wind)-1; % Convert window length to samples  
shiftval=1.3;
lpcpole=10;

%room noise
froomno = 300; 
[cb,ca] = butter(5,2*froomno/fs,'high');  %  Filter to remove LF recording noise
 
yf = filtfilt(cb,ca,y);%  Segment signal with sliding window for local processing 
%yf=ones(length(y),1);  % Insert a signal of all 1's for testing windowing



sigout= P3window(fs,yf,wlen,lpcpole,shiftval);



nfft = wlen*2;            %  number of FFT point (zero padding)
olap = floor(wlen/2);   %  Points of overlap between segments
wn = hamming(wlen); 
figure(1)
[b,faxis,taxis] = spectrogram(yf(:,1),wn,olap,nfft,fs);%  Plot over time and frequency
figure(1)    
imagesc(taxis, faxis, 20*log10(abs(b))) %  Plot spectrogram
axis('xy')  %  Flip y axis to put zero Hz on bottom
colorbar   %  Include colorbar to determine color coded magnitudes on graph 
title('Unaltered') 
xlabel('Seconds') 
ylabel('Hz')

figure(3)
plot(sigout);
title("sigout")


figure(2)
[b,faxis,taxis] = spectrogram(sigout,wn,olap,nfft,fs);%  Plot over time and frequency    
imagesc(taxis, faxis, 20*log10(abs(b))) %  Plot spectrogram
axis('xy')  %  Flip y axis to put zero Hz on bottom
colorbar   %  Include colorbar to determine color coded magnitudes on graph 
title(['Altered : ',num2str(shiftval)]) 
xlabel('Seconds') 
ylabel('Hz')

%plot(yf)

soundsc(yf(1:25000),fs);
pause;
soundsc(sigout(1:25000),fs);