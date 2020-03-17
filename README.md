# eTalk: definition and credits

The eTalk, a multimedia editing tool, is the result of collaborative and transdisciplinary work. It is part of a new form of multimodal digital literacy, while respecting the standards of scientific publishing. It is quotable entirely in details through a share button.

The first version of the eTalks code has been developed in 2012-2015 by Frédéric Kaplan and Cyril Bornet (EPFL, CH & UNIL, CH), in collaboration with Claire Clivaz (Unil, CH), and is available on Github: https://github.com/OZWE/etalk

This new version of the code has been developed by Martial Sankar and Claire Clivaz, SIB Swiss Institute of Bioinformatics, 2016-2019, https://github.com/cclivaz/etalk-docker. A course to build your own eTalk is available in the DARIAH platform #dariahTeach (teach.dariah.eu), in the course on Multimodal Literacies: https://teach.dariah.eu/course/view.php?id=24&section=3 

License: read the summary below.

Clivaz, Claire, Cécile Pache, Marion Rivoal and Martial Sankar, “Multimodal Literacies and Academic Publishing: the eTalks”, Information Services & Use 35/4 (2015), p. 251-258, https://content.iospress.com/articles/information-services-and-use/isu781

Clivaz, Claire, Marion Rivoal and Martial Sankar, “A New Plateform for Editing Digital Multimedia: The eTalks”, in New Avenues for Electronic Publishing in the Age of Infinite Collections and Citizen Science: Scale, Openness and Trust, Birgit Schmidt and Milena Dobreva (eds.), IOS Press, 2015, p. 156-159, http://ebooks.iospress.nl/publication/40894


## Getting Started

This eTalk setup is suitable for research and education purpose. It permits to use and test the eTalk application on the user's own plateform. It uses the docker-compose tool to set-up the application services (etalk php/apache, mysql, phpmyadmin).

## Installing

### Prerequisites

To install the software, all you need a Docker client on your desktop (windows, osx or linux). You can get it from [here](https://www.docker.com/products/docker#).

### FIRST STEP : install the Docker image and run the eTalk virtual machine (VM)

1. Download or clone this [repository](https://github.com/cclivaz/etalk-docker)

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

	On linux : go to the url http://localhost:88 for the viewer interface or http://localhost:88/edit for the edit interface

On MacOSX or Windows : go to the url http://192.168.99.100:88 for the viewer interface or http://192.168.99.100:88/edit for the edit interface

### SECOND STEP : make your own eTalk

To make your own etalk, you can follow the how-to from the eTalk [Make your own etalk](https://etalk2.sib.swiss/?dir=MakeETalk#0).

You can find a complete tutorial [here](https://teach.dariah.eu/course/view.php?id=24&section=3).
 
1. Create and name a folder that will contain the mp3 files inside `etalkapp/etalk-master/data/`

2. go to the __edit interface__  and start editing your eTalk.

## Deployment

There is currently no built-in deployment procedure.

## Authors

The first version of the eTalks has been developed in 2012-2015 by Frédéric Kaplan and Cyril Bornet (EPFL, CH), and is available on Github: https://github.com/OZWE/etalk

This new version has been developed_by Martial Sankar and Claire Clivaz, SIB Swiss Institute of Bioinformatics, 2016-2019, https://github.com/cclivaz/etalk-docker

*[DH+](https://digitalhumanitiesplus.sib.swiss/#/), SIB group, update 2020*

## License summary

GPULv3 license; complete version: https://github.com/sib-swiss/etalk-docker/blob/master/LICENSE.md
This program is a free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version. This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.

License of the first version 2012-2015: https://github.com/OZWE/etalk/blob/master/LICENSE.md
Copyright (c) 2012-2013 OZWE SàRL: Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions: The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software. THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.

## Disclaimer

Please note that the dependent libraries and tools (PHP, MySQL, JQuery) are NOT up-to-date.
