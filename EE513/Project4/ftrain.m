function [m1,m2,invc1,invc2] = ftrain(c1,c2)
%{
[m1,m2,invc1,invc2] = ftrain(c1,c2) is a function that practically
builds the classifier. Calculates mean and covariance.

Inputs:
    -c1 : speaker 1 feature vector
    -c2 : speaker 4 feature vector

Outputs:
    -m1     : mean speaker 1
    -m2     : mean speaker 4
    -invc1  : inverse covariance speaker 1
    -invc2  : inverse covariance speaker 4
%}

    m1=mean(c1,2);
    m2=mean(c2,2);
    cv1=cov(c1');
    cv2=cov(c2');
    invc1=inv(cv1);
    invc2=inv(cv2);
    
end