#include <sys/socket.h>
#include <netinet/in.h>
#include <netdb.h>
#include <stdio.h>
#include <string.h>
#include <stdlib.h>

static void err(char *s) {
	fprintf(stderr, "%s\n", s);
	exit(10);
}

#define STR_OK "The Secret is: Control is an Illusion.\n"
#define STR_ERR "Wrong Password\n"

#define BUFLEN 8


void server(int msgsock) {
	int i;		
	char buffer[BUFLEN];
	char ok[BUFLEN];

	ok[0] = 0;
	i = 0;
	do {
		read(msgsock, &(buffer[i]), 1);
		i++;
	}
	while (buffer[i-1] != 13);


	if (strncmp(buffer, "lula", strlen("lula")) == 0) {
		ok[0] = 1;
	}
	if (ok[0]) {
		write(msgsock, STR_OK, strlen(STR_OK));
	}
	else {
		
		write(msgsock, STR_ERR, strlen(STR_ERR));
	}
}

main(int argc, char **argv) {
  int sock, msgsock;
  struct sockaddr_in sa;

  if (argc != 2) err("usage: tcpsrv port");
  sock = socket(AF_INET, SOCK_STREAM, 0);
  if (sock == -1) err("socket");
  /* Eigene Socket-Adresse konstruieren */
  sa.sin_family = AF_INET;
  sa.sin_addr.s_addr = INADDR_ANY;
  sa.sin_port = htons(atoi(argv[1])); 
  if (bind(sock,(struct sockaddr*)&sa,sizeof(sa)))
    err("bind");
  if (listen(sock, 5) == -1) err("listen");
  for(;;) {
    msgsock = accept(sock, 0, 0);
    if (msgsock == -1) err("accept");
    server(msgsock);
    close(msgsock);
  }
}
