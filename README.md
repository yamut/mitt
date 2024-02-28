<img src="resources/images/mitt.svg" alt="mitt" width="75">

# Documentation in progress
This is a web service to catch requests and respond in a predefined way. This is in active development.

Dockerhub link: https://hub.docker.com/repository/docker/danmattern/mitt/general

Example for docker-compose

```dockerfile
    mitt:
        image: 'danmattern/mitt:latest'
        networks:
            - sail
        ports:
            - '8080:80'
```

To use
1. select http status code
2. enter some slug
3. optionally enter a body
4. submit
5. eventually your endpoint will show up at the bottom with the full url, copy this
6. `curl {url} {-H ... optional}`
7. wait, you will see the caught request next poll

To package docker build

```shell
docker build -t image_name .
docker tag image_name:tag repo/image_name:tag
docker push repo/image_name:tag
```
