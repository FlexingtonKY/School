%{
fbootstrap is my main function that loads in the speakers and
performs a bootstrap resampling method. This function was used to create
the classifier mat file which is used for runtest. both ftrain and 
ftest are called from fbootstrap to create the classifier. The function
was created by Daniel Palmer, but most of the content is from 
Dr. Donohues lectures and matlab files.

No inputs

Output
    Confusion matrix, precision, recall and accuracy, classifier.
%}


clear
bootnum=8;%number of bootstraps on data set
numtr=20;%number of samples in each class for training
numtst=20;%number of samples in each class for training
samptot=50;%total number of samples in each class
pth='C:\Users\18592\Documents\Senior Year\Semester 2\EE513\Final Project\TSTTRNskdata\';

speakers=[1,4]; %couple of the speakers did not work, (2 and 5 i think)

c1=[];
c2=[];
%read in speakers
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
        %build feature vector
        fec=fsigfv(seg,fs);
        %sort based of speaker
        if spk==1
            c1=[c1,fec];
        else
            c2=[c2,fec];
        end
    end
end

%start bootstrap
for kb=1:bootnum
   trni=randi(samptot,1,numtr);
   c1trn=c1(:,trni);
   c2trn=c2(:,trni);
   [m1,m2,invc1,invc2] = ftrain(c1trn,c2trn);

   kbot{kb,1} = m1; 
   kbot{kb,2} = m2;
   kbot{kb,3} = invc1;
   kbot{kb,4} = invc2;
   
   %testing phase
   tstindx = randi(samptot,1,numtst);
   c1tst=c1(:,tstindx);
   c2tst=c2(:,tstindx);
   cnfmat = ftest(c1tst,c2tst,m1,m2,invc1,invc2)

   %accuracy
   accur(kb)=sum(diag(cnfmat))/sum(sum(cnfmat));
   
   %performance recording
   confmatrix(:,:,kb) =cnfmat;
end


conftot=sum(confmatrix,3);

%recall
for rws=1:2
   conftot(rws,3) = round(100*conftot(rws,rws)/sum(conftot(rws,1:2)));
end

%precision
for cls=1:2
    conftot(3,cls) = round(100*conftot(cls,cls)/sum(conftot(1:2,cls)));
end

%build nice table
cl={'Classified-SPK1','Classified-SPK4','%Recall'};
r1={'SPK1','SPK2','%Precision'};
figure
t=uitable('Data',conftot,'ColumnName',cl,'RowName',r1);
set(t,'Position',[10 200, 900, 200],'FontSize',12)
set(gcf,'Position',[403 235 643 431])
%avg accuracy
acm=mean(accur)
%standard deviation
acstd=std(accur)
        