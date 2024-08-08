FROM node:lts-alpine

ENV NODE_ENV=production

WORKDIR /usr/app

COPY ./jackpot /usr/app

COPY ./centrifugo.js /usr/app

COPY ./helpers.js /usr/app

COPY ./.env /usr/app

RUN npm install

CMD [ "node", "app.js" ]
