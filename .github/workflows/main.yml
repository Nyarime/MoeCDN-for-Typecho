name: 'Getting WARP+ Traffic'

on:
  workflow_dispatch:
  push:
    branches:
     - main
  schedule:
    - cron: '33 8 * * *'

jobs:
  auto_getting_traffic:
    runs-on: ubuntu-latest
    steps:
      - name: 'Checking'
        uses: actions/checkout@v2

      - name: 'Setting Python'
        uses: actions/setup-python@v1
        with:
          python-version: '3.x'

      - name: 'Getting WARP+ Traffic'
        env:
          DEVICEID: ${{ secrets.DEVICEID }}      
        run: python warp.py
