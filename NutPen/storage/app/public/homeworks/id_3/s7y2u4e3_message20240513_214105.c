#include <stdio.h>
#include <stdlib.h>
#include <sys/types.h>
#include <sys/ipc.h>
#include <sys/sem.h>
#include <unistd.h>
#include <time.h>
#include <sys/wait.h>

#include <signal.h>
#include <sys/types.h>

int csovek[2];

int CreateSemaphore(int key){
    int szem_id = semget(key, 1, IPC_CREAT|0666);
    if(szem_id < 0){
        perror("Szem lét hiba");
    }
    
    if(semctl(szem_id, 0, SETVAL, 0) == -1){
        perror("Szem error");
    }
    return szem_id;
}

void DeleteSemaphore(int sem_id){
    semctl(sem_id, 0, IPC_RMID);
}

void Semsignal(int sem_id)
{
    struct sembuf m;
    m.sem_num = 0;
    m.sem_op = 1;
    m.sem_flg = 0;
    
    if(semop(sem_id, &m, 1) < 0){
        perror("Szemafor jelzés error");
    }
}

void SemWait(int sem_id){
    struct sembuf m;
    m.sem_num = 0;
    m.sem_op = -1;
    m.sem_flg = 0;
    
    if(semop(sem_id, &m, 1) < 0){
        perror("Szemafor jelzés error");
    }
}

void empty(){}

void Jatek(int sem,int index,int csoiras,int semmain)
{
    int randlot=0;
    int rand123=0;
    int randido=0;
   
    srand(time(NULL));
    
    signal(SIGCHLD,empty);
    
    pause();
    printf("Hali én vagyok Béla the %i!",index);
    while(1)
    {
        SemWait(sem);
        
        randido=rand() % 2 + 0;
        randlot = rand() % 21 + 13 ;
        rand123 = rand() % 3 + 1;
        
        sleep(randido);
        
        Semsignal(semmain);
        
        SemWait(sem);
        write(csoiras,&randlot,sizeof(randlot));
        SemWait(sem);
        write(csoiras,&rand123,sizeof(rand123));
        
    }
    exit(0);
}

void Szasz(int semmain, int pid1, int pid2,int semid1,int semid2, int csoolvas) //játékmester
{
    int sigcount;
    int pontszamok[2][2];
    sleep(3);
    printf("Szasz elindultam");
    kill(pid1,SIGCHLD);
    kill(pid2,SIGCHLD);
    sleep(2);
    
    for(int i=0;i <= 20;i++)
    {
        printf("%i -edik kör kezdődik",i);
       Semsignal(semid1);
        Semsignal(semid2);
        while(sigcount!=2)
        {
        SemWait(semmain); //megvárja hogy a két gyerek meghívja
        sigcount++;
        }
        sigcount=0;
        printf("A gyerekek dobtak!");
        
         Semsignal(semid1);
         sleep(1);
         int olvassok=0;
         int olvasszorzo=0;
         read(csoolvas,&olvassok,sizeof(olvassok));
         Semsignal(semid1);
         sleep(1);
         read(csoolvas,&olvasszorzo,sizeof(olvasszorzo));
         
         pontszamok[0][0]=olvassok;
         
         pontszamok[0][1]=olvasszorzo;
         
         
         Semsignal(semid2);
         sleep(1);
         olvassok=0;
         olvasszorzo=0;
         read(csoolvas,&olvassok,sizeof(olvassok));
         Semsignal(semid2);
         sleep(1);
         read(csoolvas,&olvasszorzo,sizeof(olvasszorzo));
         
         pontszamok[1][0]=olvassok;
         
         pontszamok[1][1]=olvasszorzo;
         
         printf("Az elso gyerek: %i szorosa: %i",pontszamok[0][0],pontszamok[0][1]);
         printf("Az masodik gyerek: %i szorosa: %i",pontszamok[1][0],pontszamok[1][1]);
         
    }
}




int main()
{
    int sem_id1;
    int sem_id2;
    int sem_main;
    sem_id1= CreateSemaphore(100);
    sem_id2= CreateSemaphore(200);
    sem_main= CreateSemaphore(300);
    
    printf("Vajon elindul-e a programom xd");
    
    pipe(csovek); 
    
    int pid1;
    int pid2;
    pid1=fork();
    if (pid1==-1)
    {
        printf("Hiba a folyamat létrehozásakor.\n");
        return 1;
    }
    else if(pid1==0){ //gyerek
        printf("Elso gyerek hajrá");
        Jatek(sem_id1,1,csovek[1],sem_main);
        
        
    }
    else if(pid1>0){ //szülő
         if (pid2==-1)
        {
        printf("Hiba a folyamat létrehozásakor.\n");
        return 1;
        }
        else if(pid2==0){ //gyerek
             printf("Második gyerek hajrá");
            Jatek(sem_id2,2,csovek[1],sem_main);
        }
        else if(pid2>0){ //szülő
         printf("Szülő hajrá");
        Szasz(sem_main,pid1,pid2,sem_id1,sem_id2,csovek[0]);
        }
    }
    
     kill( pid1, SIGKILL);
     kill( pid2, SIGKILL);
     DeleteSemaphore( sem_id1);
     DeleteSemaphore( sem_id2);
     DeleteSemaphore( sem_main);
    
    return 0;
}
