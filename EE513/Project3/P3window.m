function [sigout] = P3window(fs,yf,wlen,lpcpole,shiftval)
%{
[sigout] = P3window(fs,yf,wlen,lpcpole,shiftval) is a function that 
windows a signal given and aims to change formant frequencies from this 
signal to reflect a change in vocal tract size and resonance and play 
that speech segment so it sounds as natural as possible, yet no longer 
sounds like the original person.

Inputs:
    -fs : Sampling frequency
    -yf : Input signal
    -wlen : Window length
    -lpcpole : LPC order
    -shiftval : Value to shift formant angle
Outputs:
    -sigout : shifted signal
%}

sigout = zeros(size(yf(:,1))); %  Set up an accumulation array for output      
wintap = tukeywin(wlen,1); %  Create tapering window Cosine^2

%parameters for loop
start=1;
step=round(wlen/2)-1;
stop=length(yf)-wlen;
count=0; %just used for debugging
index=0; %used for window length inside of loop

for i = start:step:stop
    index=i+wlen-1; %current end to segmented data
    sseg = yf(i:index); % Taper data segment
    sseg= sseg.*
    
    [a,er] = lpc(sseg,lpcpole);  %  Compute LPC coefficent 

    r=abs(roots(a)); %lpc magnitude
    ang = angle(roots(a)); %lpc angle
    ang=(fs/2).*ang;
    ang=ang./pi;

    shift=ang.*shiftval; %perform shift
   
    shift=shift.*(2/fs);
    shift=shift.*pi;
    
    %remove angles above pi
    indices = find((shift)>pi);
    shift(indices) = [];    
    r(indices)=[];
   
    %match values mag and angles back together
    b = complex(r.*cos(shift),r.*sin(shift));
    c = (poly(b)); %find polynomials 
    
    predy = filter(a,1,sseg);  %  Compute prediction error with all zero filter
    sseg = filter(1,c,predy);  %  Compute reconstructed signal from error and all-pole

    %sometimes the matrix is transposed so ill have to uncomment the below line
    %sseg=transpose(sseg);    
    
    %splice signal together
    sigout(i:index) = sigout(i:index) + real(sseg).*wintap;
    count=count+1; %debugging purposes

end
