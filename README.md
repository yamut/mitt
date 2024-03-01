<img src="resources/images/mitt.svg" alt="mitt" width="75">

# Mitt

[![Status](https://github.com/yamut/mitt/actions/workflows/commit.yml/badge.svg)](https://github.com/yamut/mitt/actions/workflows/commit.yml)

# Documentation in progress
This is a web service to catch requests and respond in a predefined way. This is in active development.

Dockerhub link: https://hub.docker.com/repository/docker/yamut/mitt/general

Example for docker-compose

```yaml
    mitt:
        image: 'yamut/mitt:latest'
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

To test docker build

```shell
docker build -t image_name .
```

Then run it
