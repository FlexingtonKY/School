function HD = danfilt1(freq,amp,fs)
%{
danfilt1(freq,am,fs) - Matlab function that produces IIR filter ...
coefficients for a direct form 1 implementation of a complex oscillator ...
based on marginally stable systems.

Using the transfer function:
    H(z)=K/(1-2cos(alpha)z^(-1)+z^(-2))
    or rewritten as -> (z^2)*K/((z^2)-2z*cos(alpha)+1)
    or even -> y[n]=2cos(alpha)y[n-1]-y[n-2]+Kx[n]

Output:
    HD - 2 row vector containing the IIR filter coefficients. Row 1 ...
         containts the numberator values, and Row 2 contains the ...
         denominator values.
Input:
    freq - Frequency
    amp  - Amplitude
    fs   - Sampling Frequency

Example:
    fs=16000;
    amp= [1 1 2];
    freq= [100 250 500];
    HD = danfilt1(freq,amp,fs);


Author:Daniel Palmer
EE513 || 2/15/20

After trying an algebraic way to get the coeff. that didnt work,...
I had to get help with the dfilt.df1 to coefficient conversion from ...
matt ruffner who previously took the course, in which he used a DF1 ...
implimentation and parallized it, and converted from state space ...
variables to the TF coeff. I made sure to create all the logic based ...
off my own knowledge, but used the implimentation he also used.
%}

%alpha controls the frequency of oscillation and sampling frequency by
alpha=((2*pi.*freq)/fs);

%create vector for the numerators
num=[];
%create vector for the denominators
den=[];
%K scales the input to control the amplitude of oscillations. Obtained ...
%solving for r in z transform table
K=[];
for i=1:length(amp) 
    K(i) = amp(i)*sin(alpha(i));
    %numerator multiplied by respective k value to get amplitude/magnitude
    num=[num; K(i) 0 0]; 
    den=[den; 1 -2*cos(alpha(i)) 1];
end

 
%create vector to hold df1 values
dfilts = []; 
for n=1:length(freq) 
    %continuously add dfiltered objects
   dfilts=[dfilts, dfilt.df1(num(n,1:end), den(n,1:end))]; 
end

%parallel implementation used to combine df1 transfer function
fdf=dfilt.parallel(dfilts);

%Get the state space variables and d
[A,B,C,D]=fdf.ss;

%numerator and denominator coeff can be extracted by converting ...
%state space back to one transfer function
[NUMx,DENy]=ss2tf(A, B, C, D);

%put in format specified
HD = [NUMx;DENy];
