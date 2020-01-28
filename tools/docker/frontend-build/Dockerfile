FROM node:latest as build

WORKDIR /site

COPY package.json ./
COPY yarn.lock ./

RUN yarn install;
RUN mkdir -p ./dist

ENTRYPOINT yarn build;
