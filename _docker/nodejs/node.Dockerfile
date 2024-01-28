FROM node:16

WORKDIR /var/www

RUN apt-get update && apt-get install -y \
    vim \
    zip \
    unzip \
    curl

USER node

EXPOSE 5173

CMD ["sh", "-c", "npm install && npm run dev -- --host"]