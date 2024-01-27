FROM node:16

RUN apt-get update && apt-get install -y \
    vim \
    zip \
    unzip \
    curl


ENV COMPOSER_ALLOW_SUPERUSER=1

EXPOSE 5173

CMD ["sh", "-c", "npm install && npm run build -- --host"]