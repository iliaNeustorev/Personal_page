FROM node:16

USER root

RUN apt-get update \
    && apt-get install -y \
        vim \
        zip \
        unzip \
        curl \
    && rm -rf /var/lib/apt/lists/*

USER node

EXPOSE 5173

# CMD ["sh", "-c", "npm install && npm run build -- --host"]