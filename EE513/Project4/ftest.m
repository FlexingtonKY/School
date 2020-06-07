function cnfmat = ftest(c1tst,c2tst,m1,m2,invc1,invc2)
%{
cnfmat = ftest(c1tst,c2tst,m1,m2,invc1,invc2) is a function that
performs the testing on the given 

Inputs:
    -c1tst  : testing data for speaker 1
    -c2tst  : testing data for speaker 4
    -m1     : mean for speaker 1
    -m2     : mean for speaker 4
    -invc1  : inverse covarience for speaker 1
    -invc2  : inverse covarience for speaker 4

Outputs:
    -cnfmat : 
%}


   %mahanolobis distance
   cnfmat=zeros(2,2);
  
   [r,c]=size(c1tst); %assuming same size
   %class 1 test
   for kt=1:c
       %if smaller than d12 correct, else incorrect
       d11=(c1tst(:,kt)-m1)'*invc1*(c1tst(:,kt)-m1); 
       d12=(c1tst(:,kt)-m2)'*invc2*(c1tst(:,kt)-m2);
       %accumulate confusion matrix
       if d11<=d12
           cnfmat(1,1)=cnfmat(1,1)+1; %correct counter
       else
           cnfmat(1,2)=cnfmat(1,2)+1; %incorrect counter
       end
       
       %class 2 test
       d21=(c2tst(:,kt)-m1)'*invc1*(c2tst(:,kt)-m1);
       d22=(c2tst(:,kt)-m2)'*invc2*(c2tst(:,kt)-m2);
       %accumulate confusion matrix
       if d22>=d21
          cnfmat(2,1)=cnfmat(2,1)+1;
       else
          cnfmat(2,2)=cnfmat(2,2)+1;
       end
       
   end
end