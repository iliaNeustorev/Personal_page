FROM node:20

WORKDIR /var/www

USER node

EXPOSE 5173

CMD ["sh", "-c", "npm install && npm run dev -- --host"]