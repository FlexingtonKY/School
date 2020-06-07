%{
This file will generate a sequence of 52 randomly selected notes over a two
octave scale. The time scale of the notes and the index of the note on the
octave scale will be randomly selected from a predetermined list for each
note, and the sampling frequency, base duration, and base frequency will be
kept constant each time.

Author: Daniel Palmer
Class:EE513
Date:1/27/2020

%}

%create array for the duration scaling values we can pick from
time_scale= [2, 1, 3/4, 1/2, 3/8, 1/4, 3/16, 1/8, 1/16, 1/32] ;
%create array for the indexes of the scale we can pick from
indexes = [-7 -6 -5 -3 -2 0 1 2 4 5 7];

%randomly select 52 values from 1 to 10 which corresponds to time_scales
%size
random_time_scale = randi(10,1,52);
%randomly select 52 values from 1 to 11 which corresponds to indexes vector
%size
random_indexes = randi(11,1,52);

%initialize the randome scale vector
rand_scale = [];
for i=1:52 %create 52 notes
   %get tone vector using input values, and the randomly selected values we
   %have already computed
   note = settone(200,.5,16e3,indexes(random_indexes(i)),time_scale(random_time_scale(i)));
   %append note to scale
   rand_scale = [rand_scale,note];
end

%t = [0:59999]/sampf;
soundsc(rand_scale,16e3)
%plot(t,two_octave_scale);  xlabel('Seconds');  ylabel('Amplitude')
audiowrite('randtest.wav', rand_scale, 16e3)
