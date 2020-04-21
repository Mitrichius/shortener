#!/usr/bin/env bash

set -e

yarn install --ignore-optional
yarn encore production
sh