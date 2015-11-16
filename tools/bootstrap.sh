#!/bin/bash

set -e

BOOTSTRAPVER=3.3.5
BOOTSTRAPDIR="bootstrap-${BOOTSTRAPVER}-dist"
BOOTSTRAP="${BOOTSTRAPDIR}.zip"
WDIR=$(dirname "$0")

cd ${WDIR}
if [ ! -f ${BOOTSTRAP} ]; then
  wget "https://github.com/twbs/bootstrap/releases/download/v${BOOTSTRAPVER}/${BOOTSTRAP}"
fi
cd ../tools/
unzip ${BOOTSTRAP}
chmod 755 ${BOOTSTRAPDIR}
find ${BOOTSTRAPDIR} -type d -exec chmod 755 {} +
find ${BOOTSTRAPDIR} -type f -exec chmod 644 {} +
cp -a ${BOOTSTRAPDIR}/css/bootstrap.min.css ../css/
cp -a ${BOOTSTRAPDIR}/css/bootstrap-theme.min.css ../css/
cp -a ${BOOTSTRAPDIR}/fonts ../
cp -a ${BOOTSTRAPDIR}/js/bootstrap.min.js ../js/
rm -rf ${BOOTSTRAPDIR}
