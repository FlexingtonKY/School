%{
This matlab file is to test the two octave scale using the settone function
created. The function will produce a sounds given the function soundsc that
will represent a two octave scale, given a reference frequency, duration,
duration scale, and sampling frequency. The file will also do an audio
write so that the sound is saved in a .wav file

Author: Daniel Palmer
Class:EE513
Date:1/27/2020

%}
sampf=16000;    %sampling frequency
freq=400;       %reference frequency
dur=.25;        %tone duration
scale=1;        %duration scale

%{
Testing commands from lines 8-12
sig = settone(freq,dur,sampf,index,scale);

third = settone(331, 0.25, 16e3, 3, .5);
octave_below = settone(331, 0.25, 16e3, -7, 2);
combine= [third,octave_below];
%}

%initialize array for the two octave scale
two_octave_scale = [];
for i=-7:7  %iterate through each index of the octave scale
   %call settone function to get vector of notes
   note = settone(freq,.25,sampf,i,1);
   %append note vector to the octave scale
   two_octave_scale =[two_octave_scale,note];
end

%get time scale to plot
t = [0:59999]/sampf;
%play sound
soundsc(two_octave_scale,sampf)
%plot scale
plot(t,two_octave_scale);  xlabel('Seconds');  ylabel('Amplitude')
%write to audio file
audiowrite('octavetest.wav', two_octave_scale, sampf)
