#!/bin/bash

set -e

MPDF="MPDF60.zip"
MPDFDIR="mpdf60"
WDIR=$(dirname "$0")

cd ${WDIR}
if [ ! -f ${MPDF} ]; then
  wget "http://mpdf1.com/repos/${MPDF}"
fi
cd ../include/
if [ -d ${MPDFDIR} ]; then
  rm -rf ./${MPDFDIR}
fi
unzip ../tools/${MPDF}
chmod 755 ${MPDFDIR}
find ${MPDFDIR} -type d -exec chmod 755 {} +
find ${MPDFDIR} -type f -exec chmod 644 {} +
if [ $(id -u) = 0 ]; then
    chown -R apache:apache ${MPDFDIR}
else
    chmod 777 ${MPDFDIR}/ttfontdata ${MPDFDIR}/tmp
fi
patch -p0 < ../tools/mpdf60_indic.patch
