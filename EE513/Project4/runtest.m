%{
runtest is my main function that loads in the speakers and
used a bootsrap resample to determin the classifier. clspar is contains 
the meanfeature vector for speakers 1 and 4 along with the invers
covariance for 1 and 4. This acted as my classifier. The function
was created by Daniel Palmer, but most of the content is from 
Dr. Donohues lectures and matlab files.

No inputs

Output
    Confusion matrix, precision, recall and accuracy, classifier.

Things you may have to change at the beginning:
    -samptot:samples to run for each class
    -speakers:adds on to the filename to get each speaker wav file
%}



clear
samptot=50;%total number of samples in each class
pth='C:\Users\18592\Documents\Senior Year\Semester 2\EE513\Final Project\TSTTRNskdata\';
speakers=[1,4]; %couple of the speakers did not work, (2 and 5 i think)

c1=[];
c2=[];
for k=1:samptot
    for spk=1:2
        if k<10
            wfiles=['spk0' num2str(speakers(spk)) '_00' num2str(k) '.wav'];
            [y,fso]=audioread([pth,wfiles]);
            seg = resample(y,8000,fso);%  Preprocessoing
            fs=8000;
        elseif k < 100
            wfiles=['spk0' num2str(speakers(spk)) '_0' num2str(k) '.wav'];
            [y,fso]=audioread([pth,wfiles]); 
            seg = resample(y,8000,fso);%  Preprocessoing
            fs=8000;
        else
            wfiles=['spk0' num2str(speakers(spk)) '_' num2str(k) '.wav'];
            [y,fso]=audioread([pth,wfiles]);
            seg = resample(y,8000,fso);%  Preprocessoing
            fs=8000;
        end
        fec=fsigfv(seg,fs);
        if spk==1
            c1=[c1,fec];
        else
            c2=[c2,fec];
        end
    end
end

load('clspar.mat')

   %testing phase
   cnfmat = ftest(c1,c2,m1,m2,invc1,invc2)

   %accuracy
   accur=sum(diag(cnfmat))/sum(sum(cnfmat));
   
   %performance recording
   confmatrix =cnfmat;



conftot=sum(confmatrix,3);

for rws=1:2
   conftot(rws,3) = round(100*conftot(rws,rws)/sum(conftot(rws,1:2)));
end

for cls=1:2
    conftot(3,cls) = round(100*conftot(cls,cls)/sum(conftot(1:2,cls)));
end

cl={'Classified-SPK1','Classified-SPK4','%Recall'};
r1={'SPK1','SPK2','%Precision'};
figure
t=uitable('Data',conftot,'ColumnName',cl,'RowName',r1);
set(t,'Position',[10, 200, 900, 200],'FontSize',12)
set(gcf,'Position',[403, 235, 643, 431])
%avg accuracy
acm=mean(accur)
%standard deviation
acstd=std(accur)
        