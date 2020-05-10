#include <iostream>
using namespace std;
class PrimeNos{
  public:void findPrimeNo(){
    int i=0, j, k=10;
    do{
     i++;
     for(j = 2; j <= (i/j); j++){
        if(!(i%j)){
           break; 
        }
     }//for
     if(j > (i/j)){
        cout << i << " is prime\n";
     }
    }while(i<k);
  } //findPrimeNo
}; // PrimeNos

int main () {
  PrimeNos pn;
  pn.findPrimeNo(); 
  return 0;
}
