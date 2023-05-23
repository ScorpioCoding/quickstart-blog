#usage make then command
#exp. make up

help:
	@echo " make                     Makefile command"
	@echo " make up:                 docker compose up -d"
	@echo "                          Create and Start containers"
	@echo " make up-b:               docker compose up -d --build"
	@echo "                          Build, Create and Start containers"
	@echo " make down:               docker compose down"
	@echo "                          Stop and remove containers, networks"
	@echo " make down-o:             docker compose down --remove-orphans"
	@echo "                          Stop and remove containers, networks and orphans"
	@echo " make down-v:             docker compose down -v"
	@echo "                          Stop and remove containers, networks and volumes"
	@echo " make list:               docker compose ps"
	@echo "                          List containers"
	@echo " make list-i:             docker image ls"
	@echo "                          List images"
	@echo " make list-c:             docker container ls -a"
	@echo "                          List containers"
	@echo " make prune-i:            docker image prune"
	@echo "                          Remove unused images"
	@echo " make prune-c:            docker container prune"
	@echo "                          Remove all stopped containers"


# make up  List containers
up:
	@echo "docker compose up -d"
	docker compose up -d

# make up-b
up-b:
	@echo "docker compose up -d --build"
	docker compose up -d --build

# make down
down:
	@echo "docker compose down"
	docker compose down
	
# make down
down-o:
	@echo "docker compose down --remove-orphans"
	docker compose down --remove-orphans

#make down-v {volume also}
down-v:
	@echo "docker compose down -v {volume}"
	docker compose down -v

#make list
list:
	@echo "docker compose ps -a"
	docker compose ps -a

#make list-i
list-i:
	@echo "docker image ls"
	docker image ls

#make list-c
list-c:
	@echo "docker container ls -a"
	docker container ls -a

#make prune-i
prune-i:
	@echo "remove all unused images"
	docker image prune

#make prune-c
prune-c:
	@echo "remove all stopped containers"
	docker container prune


