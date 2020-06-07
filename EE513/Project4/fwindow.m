function [ff1,dffd,ddffd] = fwindow(yf,fs,wlen)
%{
[ff1,dffd,ddffd] = fwindow(yf,fs,wlen) is a function that 
windows a signal given and computes the MC and delta vectors for 
the respective segments

Inputs:
    -fs     : Sampling frequency
    -yf     : Input signal
    -wlen   : Window length
Outputs:
    -ff1    :  melcep o gram matrix
    -dffd   : delta matrix
    -ddffd  : delta delta matrix
%}

      
wintap = hamming(wlen); %  Create tapering window Cosine^2

%parameters for loop
start=1;
step=round(wlen/2)-1;
stop=length(yf)-wlen;
count=0; %just used for debugging
index=0; %used for window length inside of loop
ff1=[];
ffsig=[];

for i = start:step:stop
    index=i+wlen-1; %current end to segmented data
    sseg = yf(i:index).*wintap; % Taper data segment
    
    
    ffd=mfcc(sseg,fs);
    ff1=[ff1 ffd];
    ffspec=fft(sseg,2*wlen);
    ffsig=[ffsig ffspec(1:wlen)];
    
    count=count+1; %debugging purposes

end

%used for plotting purposes
[r,c] = size(ff1);
[rs,ca]=size(ffsig);
faxspec = (fs)*[0:rs-1]/(2*rs);
taxsig=[0:length(yf)-1]/fs;
taxcc=taxsig(end)*[0:c-1]/c;

%delta
dffd=zeros(r,c);
for kkd=3:c-2
    dffd(:,kkd)=(1*(ff1(:,kkd+1)-ff1(:,kkd-1))+2*(ff1(:,kkd+2)-ff1(:,kkd-2)))/10;
end

%delta delta
ddffd=zeros(r,c);
for kkd=3:c-2
    ddffd(:,kkd)=(1*(dffd(:,kkd+1)-dffd(:,kkd-1))+2*(dffd(:,kkd+2)-dffd(:,kkd-2)))/10;
end


