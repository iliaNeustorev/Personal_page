FROM node:16

WORKDIR /var/www

USER node

EXPOSE 5173

CMD ["sh", "-c", "npm install && npm run build"]