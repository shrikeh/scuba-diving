FROM node:latest as build

WORKDIR /site

COPY package.json ./
COPY yarn.lock ./

RUN mkdir -p /node_modules

ENV NODE_PATH=/node_modules

RUN yarn install;
RUN mkdir -p ./dist

ENTRYPOINT yarn install && yarn build;
