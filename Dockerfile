FROM dimaip/docker-neos-alpine:latest
ENV PHP_TIMEZONE=Europe/Moscow
ENV REPOSITORY_URL=https://github.com/psmb/1917Distr
ENV AWS_ENDPOINT=https://hb.bizmrg.com
ENV AWS_BACKUP_ARN=s3://psmb-neos-resources/db/1917/
ENV DONT_PUBLISH_PERSISTENT=1
VOLUME /data/www/_Resources
RUN /provision-neos.sh
