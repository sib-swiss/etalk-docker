# eTalk

eTalk, a multimedia editing tool, is the result of collaborative and transdisciplinary work.
It is part of a new form of multimodal digital literacy while respecting the standards of scientific publishing. It is quotable in details through a share button.

## Getting Started

This eTalk setup is suitable for research and education purpose. It permits to use and test the eTalk application on the user's own plateform. 

## Installing

### Prerequisites

To install the software, all you need a Docker client on your desktop (windows, osx or linux). You can get it from [here](https://www.docker.com/products/docker#).

### FIRST STEP : install the Docker image and run the eTalk virtual machine (VM)

1. Download or clone this [repository](https://gitlab.isb-sib.ch/etalk-group/etalk-docker)

2. Open a terminal in linux or open the "docker quick start terminal" in Windows or MacOSX (that comes along with the installation).

3. Navigate to the installation directory (e.g. `/usr/local/bin/etalk-docker`)

4. Secondly, build the image with : 

	```
	$ docker-compose build
	```

5. Then, run the eTalk application with :

	```
	$ docker-compose up -d
	```

6. Open a browser

	go to the url http://localhost:88 for the  __viewer interface__ or http://localhost:88/edit for the __edit interface__

### SECOND STEP : make your own eTalk

To make your own etalk, you can follow the how-to from the eTalk [Make your own etalk](https://etalk2.sib.swiss/?dir=MakeETalk#0).

You can find a complete tutorial [here](https://teach.dariah.eu/course/view.php?id=24&section=3).
 
1. Create and name a folder that will contain the mp3 files inside `etalkapp/etalk-master/data/`

2. go to the __edit interface__  and start editing your eTalk.

## Deployment

There is currently no built-in deployment procedure.

## Authors

* *DH+, SIB group*

## License

This program is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

## Disclaimer

Please note that the dependent libraries and tools (PHP, MySQL, JQuery) are NOT up-to-date.