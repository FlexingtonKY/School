function [fec] = fsigfv(seg,fs)
%{
[fec] = fsigfv(seg,fs) is a function that extracts the most 
relevant features from the mel matrix. The mel matrix is gotten 
from the window function, and that is taken apart and analyzed
to pick out certain features that are the most important.


Inputs:
    -seg    : Sampling frequency
    -fs     : Input signal

Outputs:
    -fec    : feature vector
%}


    melrang=[1:12];     
    seglen=60e-3;   
    wlen = round(fs*seglen)+1;        %  Length of actual point extracted from signal segment


    tseg=trimit(seg,fs);

    [ff1,dffd,ddffd] = fwindow(tseg,fs,wlen);


    %find max of deltas in first half and use point in feature vector
    [mv,~]=max(dffd(2:12,:));
    hp=floor(length(mv)/2);
    [~,mp]=max(mv(1:hp));
    %build feature vector for first half
    fecl=[ff1(melrang,mp);dffd(melrang,mp);ddffd(melrang,mp)];

    %find max of deltas in last half and use point in feature vector
    [mv,~]=max(dffd(2:12,:));
    hp=floor(length(mv)/2);
    [~,mp]=max(mv(hp+1:end));
    mp=hp+mp;
    %build feature vector for last half
    fech=[ff1(melrang,mp);dffd(melrang,mp);ddffd(melrang,mp)];

    %use features shown in the graphs in the report
    fec=[fech(2);fech(11);fecl(11);fech(12);fecl(12);fech(14);fech(20)];

end