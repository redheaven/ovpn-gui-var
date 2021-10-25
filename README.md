
  

## Creating a VPN-servers  in different AWS regions with 2 Factor Authentication using OpenVPN and Docker

   

## How it works

  

This OpenVPN solution uses three separate open-source projects:

  

*  [OpenVPN](https://github.com/OpenVPN/openvpn) which provides the VPN functionality

 *  [PHP project](https://github.com/dpnkvrm/OpenVPN-Admin) - original project.

*  [Dockerfile and Docker compose file](https://github.com/armindocachada/OpenVPN-Docker-GoogleAuth) - version in docker.

  

* The [PHP gangsta — Google Authenticator project](https://github.com/PHPGangsta/GoogleAuthenticator) — a PHP implementation of the Google Authenticator reference app originally written for mobile.

  
Schema of our project is pretty simple:

1. We have one master instance with Web server, Google auth, mysql server, and OpenVPN server in Docker.
2. Slave instance's must be connected to base on our master instance.
3. Slave instance's doesn'thave only mysql server. 
4. In each instance we have separate OpenVPN server wich used for generation certificate, key and ovpn config of this instance.

  

Our ***master*** instance will run 4 docker containers:

  

*  **openvpn** docker container runs the openvpn server

  

* **webadmin** runs the webadmin interface for OpenVPN

  

* **googleauth** is a docker container that runs a small PHP microservice to do the 2 step authentication(pairing and validation).

  

*  **mariadb** is docker container that runs a mysql database named openvpn-admin. It used for store user and admin **openvpn** and **webgui** credentials.

***Slave*** instances will run only 3 containers:

*  **openvpn**

* **webadmin** 
* **googleauth** 

  

Preparation:

  

1. Install **Docker**
2. Install **docker-compose**
3. Install **git**
  

Steps for setup ***master*** instance:


    $git clone git@bitbucket.org:teamworkspirit/vpn-network.git
    
    $cd vpn-network
    
    MYSQL_ROOT_PASSWORD=YourPass OPENVPN_ADMIN_PASSWORD=YourPass HOST_ADDR=AddressOfDbServer OPENVPN_SERVER_ADDR=AddressOfVpnServer docker-compose up -d 

> * **MUST BE CHANGED**:
> * MYSQL_ROOT_PASSWORD= password for your mysql **root** user
> * OPENVPN_ADMIN_PASSWORD= password for you mysql **openvpn-admin**  user
> * HOST_ADDR= address of your instance with **mysql**
> * OPENVPN_SERVER_ADDR= address of our **current** instance 

  
  Steps for setup ***slave*** instance:

    $git clone git@bitbucket.org:teamworkspirit/vpn-network.git
    
    $cd vpn-network
    
    
    MYSQL_ROOT_PASSWORD=YourPass OPENVPN_ADMIN_PASSWORD=YourPass HOST_ADDR=AddressOfDbServer OPENVPN_SERVER_ADDR=AddressOfVpnServer docker-compose up openvpn -d && MYSQL_ROOT_PASSWORD=YourPass OPENVPN_ADMIN_PASSWORD=YourPass HOST_ADDR=AddressOfDbServer OPENVPN_SERVER_ADDR=AddressOfVpnServer docker-compose up webadmin -d && MYSQL_ROOT_PASSWORD=YourPass OPENVPN_ADMIN_PASSWORD=YourPass HOST_ADDR=AddressOfDbServer OPENVPN_SERVER_ADDR=AddressOfVpnServer docker-compose up googleauth -d

  
> * **MUST BE CHANGED**:
> * MYSQL_ROOT_PASSWORD= password for your mysql **root** user
> * OPENVPN_ADMIN_PASSWORD= password for you mysql **openvpn-admin**  user
> * HOST_ADDR= IP address of your instance with **mysql**
> * OPENVPN_SERVER_ADDR= IP address of our **current** instance 

  

To access the OpenVPN web administration interface you can use:

  

[http://ServerAddress/](http://ServerAddress/)

  

![OpenVPN Web Admin](https://cdn-images-1.medium.com/max/2430/1*WC1JKfOPNKG4vAsObzXcWg.png)

  

Before we can log in, we need to do the initial setup:

  

Go to the following URL:

  

[http://ServerAddress/index.php?installation](http://ServerAddress/index.php?installation)

  

![](https://cdn-images-1.medium.com/max/2532/1*nQrPBCOEkd98HSJm5A0Aig.png)

  

Pick an admin username and a secure password.

  

![](https://cdn-images-1.medium.com/max/2000/1*9NwA02Ozurt6_HceMDbapQ.png)

  

Now we should be able to login:

  

![](https://cdn-images-1.medium.com/max/3224/1*xqEHWaHKIqYRI5fPmlxvkA.png)

  

Let’s create a VPN user

  

![](https://cdn-images-1.medium.com/max/2000/1*7J2oxmSdQAGol_gh0Z1rmQ.png)

  

The new user should be visible in the list below:

  

![](https://cdn-images-1.medium.com/max/3186/1*zItIIZZNx60VWX6wrl8euA.png)

  

Now that you have a VPN user, there are two steps required for setup of each VPN user.


  

1.  **Download OpenVPN zip file:** To be able to create a new profile, you need to download a ZIP file that contains the client certificate(.ovpn file) that you will need later when setting up the OpenVPN client.

  

2. Setting up the OpenVPN client

  

### Setting up 2-Factor Authentication (if you need it)

  

1. Navigate to the OpenVPN Web Administration Page, at [http://ServerAddress](http://ServerAddress:8080)

  

2. Click **Setup Google Authentication** on the navigation bar

  

3. Enter the credentials given by your administrator to log in.

  

![](https://cdn-images-1.medium.com/max/2000/1*sCNwY7V-bI3uSMnx4g72FQ.png)

  

4. After login you should see the following page:

  

![](https://cdn-images-1.medium.com/max/2162/1*uY6zrRkyOjiwtvSDVCwwoA.png)

  

At this stage, you should install the Google Authenticator app on your mobile phone.

  

Open your **Google Authenticator App**, and press the ‘**+**’ icon in the top right and then press ‘Scan Barcode’

  

Point your camera at the QR code and you should see the profile appear with your details.

  

5. Next you need to type the 6 digit PIN number you see in the Authenticator app. If it all goes well, the pairing will succeed and you will see a “Pairing succeeded” message. If you see an error instead, it is possible that you were too slow typing the PIN number. Try again.

  

**Download OpenVPN zip file**

  

1. Navigate to the OpenVPN Web Administration Page, at [http://ServerAddress](http://ServerAddress)

  

2. Click **Configurations** on the navigation bar

  

3. Enter the VPN user credentials given by your administrator to log in.

  

4. Choose the correct OS from the dropdown: Linux, OS X(MacOS) or Windows

  

5. Click “**Get Configuration Files**”. You will be downloading a ZIP file with the required client configuration for OpenVPN. Keep it in a safe folder. You will need it soon.

  

## Setting up the OpenVPN Client

 

  

Download the OpenVPN client for your operating system. Ensure that you download version 3 or above. Version 2 will not work.

  

**MacOS Download:**  [https://openvpn.net/downloads/openvpn-connect-v3-macos.dmg](https://openvpn.net/downloads/openvpn-connect-v3-macos.dmg)

  

**Windows Download:**  [https://openvpn.net/downloads/openvpn-connect-v3-windows.msi](https://openvpn.net/downloads/openvpn-connect-v3-windows.msi)

  

Install the OpenVPN client.

  

### Install the client Certificate

  

After installing the OpenVPN client, you should see the following screen:

  

![Initial screen without any VPN profiles](https://cdn-images-1.medium.com/max/2000/1*wB2bB5zKo-OwRECJkUM5AQ.jpeg)

  

Click the + sign, and select file.

  

![](https://cdn-images-1.medium.com/max/2000/1*HF5zSJMY6hy147uHFManxg.png)

  

Select the client.ovpn file you downloaded in the earlier step(don’t forget to unzip).

  

![](https://cdn-images-1.medium.com/max/2000/1*AfxGMKdShLwzXANXVHiRCQ.jpeg)

  

At this stage, you need to supply your VPN credentials. Click **Save Password**. But remember that every time you log in, if you don’t disable 2 Factor Authentication you will need to add your 6 digits **PIN** number to the end of your password. This is slightly annoying, but worth it because of the extra security.

  

Click **Save** when you are done.

  

And that’s it, you now have a VPN profile setup ready to connect.

  

![](https://cdn-images-1.medium.com/max/2000/1*HuRBhf-9CrEDOMzVxAVsTg.png)

  

### Connecting to the VPN using 2 Factor Authentication

  

Every time you try to connect to the VPN you will need to supply a six-digit PIN that is everchanging. This PIN is available from the google authenticator app.

  

1. Just before you login take note of the latest PIN number(you need to be quick)

  

2. Click the toggle button on the left-hand side to connect to the VPN

  

3. At this stage you will be prompted for your password.

  

Enter your password and add at the end of your password without any extra spaces the PIN number from step 1. Click OK

  

4. You will see a Connection Error message. Click “Continue”

  

![](https://cdn-images-1.medium.com/max/2000/1*WvhTHumi5YFAwTK1CO1gtw.png)

  

5. If all goes well, you are connected to the VPN!

  

![](https://cdn-images-1.medium.com/max/2000/1*gQ0GMx0WvPqKqYFwYXR6Xw.png)



Hope you enjoy it.

  

## Resources:

  

[**armindocachada/OpenVPN-Docker-GoogleAuth**](https://github.com/armindocachada/OpenVPN-Docker-GoogleAuth)
  

[**armindocachada/OpenVPN-Admin**](https://github.com/armindocachada/OpenVPN-Admin)

  
[**Chocobozzz/OpenVPN-Admin**](https://github.com/Chocobozzz/OpenVPN-Admin)

  
[**PHPGangsta/GoogleAuthenticator**](https://github.com/PHPGangsta/GoogleAuthenticator)

[**Dockerfile and Docker compose file**](https://github.com/armindocachada/OpenVPN-Docker-GoogleAuth) - version in docker.
  
## Modification of project
You can easily modificate PHP project. It stores in `php-project`  folder.
