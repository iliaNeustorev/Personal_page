FROM node:16

USER node

RUN sudo apt-get update \
    && sudo apt-get install -y \
        vim \
        zip \
        unzip \
        curl \
    && sudo rm -rf /var/lib/apt/lists/*

WORKDIR /home/node/app

EXPOSE 5173


CMD ["sh", "-c", "npm install && npm run build -- --host"]