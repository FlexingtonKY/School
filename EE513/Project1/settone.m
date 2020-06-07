function [y] = settone(freq,dur,sampf,index,scale)
%{
The purpose of this function is to return a vector [y] that contains a 
series of points necessary to produce a specified tone, given a set of
parameters. This function takes in a key reference frequency, duration of
tone, sampling frequency, index of the note in the scale, and the scale of
the duration.

This function will be called by the two test functions octavetest.m and
randtest.m, both of which are explained more in detailed in their
respective files.

Author: Daniel Palmer
Class:EE513
Date:1/27/2020

%}

%create array of the values needed to create the octave scale
scalearray = [2^(0/12),2^(2/12),2^(4/12),2^(5/12),2^(7/12),2^(9/12),2^(11/12),2^(12/12)];
negscalearray=[2^(12/12-1),2^(11/12-1),2^(9/12-1),2^(7/12-1),2^(5/12-1),2^(4/12-1),2^(2/12-1),2^(0/12-1)];

t = [0:round(dur*scale*sampf)-1]/sampf;  % Sampled time axis
if(index<0)
    %create sample signal by decrementing in the octave scale
    y = cos(2*pi*freq*t*(negscalearray((index*-1)+1)));   
else
    %create sample signal by incrementing in the octave scale
    y = cos(2*pi*scalearray(index+1)*freq*t); 
end
