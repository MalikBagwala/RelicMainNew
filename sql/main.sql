CREATE TABLE relic_user(
  uid SERIAL PRIMARY KEY,
  uname VARCHAR(50) NOT NULL,
  uemail VARCHAR(255) NOT NULL,
  upass VARCHAR(50) NOT NULL
);

CREATE TABLE cart(
  cid SERIAL PRIMARY KEY,
  uid INT UNIQUE references relic_user(uid),
  sid INT references smartphone(pid),
  qty INT NOT NULL
);

CREATE TABLE admins(
aid SERIAL PRIMARY KEY,
aname VARCHAR(30) NOT NULL,
aemail TEXT NOT NULL UNIQUE,
apass TEXT NOT NULL,
acity VARCHAR(30) NOT NULL,
apos VARCHAR(20) NOT NULL,
exp INT
);

INSERT INTO admins VALUES(DEFAULT,'malik','malik@gmail.com','1234','nasik','senior-developer',1);
INSERT INTO admins VALUES(DEFAULT,'rean','rean@gmail.com','1234','nasik','senior-developer',1);

CREATE TABLE smartphone(
  pid SERIAL PRIMARY KEY,
  pname VARCHAR(100) NOT NULL,
  pdesc TEXT NOT NULL,
  pproc VARCHAR(25),
  pdisp VARCHAR(20) NOT NULL,
  ppcam INT NOT NULL,
  pscam INT NOT NULL,
  pram INT NOT NULL,
  pstore INT NOT NULL,
  pbatt INT NOT NULL,
  price FLOAT NOT NULL,
  pimg VARCHAR(25)
);

CREATE TABLE cart(
  id SERIAL PRIMARY KEY,
  uid INT references relic_user(uid),
  date DATE,
  checked char NOT NULL DEFAULT 'N'
);

CREATE TABLE cartItems(
  cid SERIAL PRIMARY KEY,
  id INT references cart(id),
  pid INT references smartphone(pid),
  qty INT CHECK(qty < 5)
);
SELECT smartphone.pid,pname,price,qty
FROM relic_user,smartphone,cart,cartitems
WHERE relic_user.uid = cart.uid AND
      cart.id = cartitems.id AND
      smartphone.pid = cartitems.pid AND
      relic_user.uid = 3 ORDER BY pid;

SELECT count(qty)
FROM relic_user,smartphone,cart,cartitems
WHERE relic_user.uid = cart.uid AND
      cart.id = cartitems.id AND
      smartphone.pid = cartitems.pid AND
      relic_user.uid = 3 ORDER BY pid;

SELECT smartphone.pid,pname,qty,price
FROM smartphone,relic_user,cart,cartitems
WHERE relic_user.uid = cart.uid AND
      card.id = cartitems.id AND
      cart.uid = 6;
INSERT INTO relic_user(uname,uemail,upass) VALUES('','','');
INSERT INTO smartphone VALUES(DEFAULT,'galaxy s9','Samsung brings together a blend of beautiful design and innovative technology in forging the S9+. It provides a plethora of features such as augmented reality emoji, Super Slow-mo, Live Translation, Intelligent Scan, which are run seamlessly by an octa-core processor and 6 GB of RAM. The 14.73-cm (5.8) Quad HD+ Super AMOLED display coupled with the Dolby Atmos surround-sound technology provide a theatre-like feel while watching videos. Capture and savour your moments with the (12 MP + 12 MP) rear camera and the 8 MP front camera. ','snapdragon 845','1440x2960',12,8,4,64,3000,49990,'galaxy s9.jpg');
INSERT INTO smartphone VALUES(DEFAULT,'pixel 3','Staying too far from your loved ones, video call them for hours on end. The weather is romantic, listen to your favourite playlists all day long. Dont want to go out this weekend, then binge watch your favourite series on the internet or perhaps play your favourite mobile video game, do all that and much more. The pixel 3 ensures that theres never a dull moment, all thanks to its powerful battery, impressive cameras and its expansive bezel-less display.','snapdragon 845','1440x2960',12,8,4,64,2915,64623,'pixel 3.jpg');

INSERT INTO smartphone VALUES(DEFAULT,'galaxy s8','Explore a world of endless possibilities with the Samsung Galaxy S8. Featuring the innovative Infinity Display, this smartphone offers a smooth, curved surface without sharp angles. With an array of security features, such as the Iris Scanner, Face Recognition and a fingerprint sensor, the Galaxy S8 keeps all your private data safe from unauthorized access. Its 10nm processor, along with 4 GB of RAM, delivers a power-packed performance. The 8 MP front camera and the 12 MP rear camera further add to the Galaxy S8 appeal.','
Exynos 8895','1440x2960',12,8,4,64,3000,51000,'galaxy s8.jpg');

INSERT INTO smartphone VALUES(DEFAULT,'oneplus 6t','The OnePlus 6T runs Android 8.1 Oreo out of the box and is powered by a Snapdragon 845 octa core SoC. It has Adreno 630 GPU. The phone will have 6GB of RAM and 256 GB of memory. It will be backed by a 3,700mAh battery. It has sleek dimensions of 157.50 x 75.70 x 8.20 mm. Connectivity options included in the device are Wi-Fi, Bluetooth, USB, GPS, NFC, and USB 3.1. It comes with an array of inbuilt sensors including accelerometer, gyroscope, proximity, and compass.','
snapdragon 845','1080 x 2340',20,16,8,128,3700,37999,'oneplus 6t.jpg');

INSERT INTO smartphone VALUES(DEFAULT,'redmi note 4','The Xiaomi Redmi Note 4 is powered by 2GHz octa-core processor and it comes with 4GB of RAM. The phone packs 64GB of internal storage that can be expanded up to 128GB via a microSD card. As far as the cameras are concerned, the Xiaomi Redmi Note 4 packs a 13-megapixel (f/2.0, 1.12-micron) primary camera on the rear and a 5-megapixel front shooter for selfies.','
snapdragon 625','1080 x 1920',13,5,4,64,4100,11999,'redmi note 4.jpg');

INSERT INTO smartphone VALUES(DEFAULT,'honor 9n','From movies to mobile games, now enjoy a seamless viewing experience on this smartphone, thanks to its Honor Notch FullView 14.84 cm FHD+ Display (19:9 aspect ratio). It offers more screen space for a stunning visual experience. The 12-layer premium glass design on the rear, and the double-sided 2.5D curved glass lend the Honor 9N a sleek and an elegant look. Capture bright and beautiful selfies, even in dimly lit conditions with this phones 16 MP front camera. Take your photography-game up a notch with the 13+2 MP dual rear camera system. It comes with a professional-level bokeh mode for stunning photos. The Kirin 659 Octa-core 2.36 GHz processor of this phone ensures a lag-free, multitasking experience. ','
Kirin 659','1080 x 1920',13,16,4,64,3000,12999,'honor 9n.jpg');

INSERT INTO smartphone VALUES(DEFAULT,'honor play','Honor Play - the fastest phone in the market is powered with Huaweis Flagship Kirin 970, AI processor and GPU Turbo enabling crazy speed and efficiency. It boasts of dual primary cameras of 16MP + 2MP with AI scene recognition and 16MP AI selfie. Up to 6GB of RAM will ensure phone runs smoothly, even the most memory intensive applications show no signs of lag. 64GB of internal storage will be open for expansion upto 256GB via a microSD card. The phone comes with large 3750 mAh battery to support its 6.3 inch FHD+ screen with IPS LCD display having a resolution of 1080 x 2340 at 409 ppi.','
Kirin 970','1080 x 2340',16,16,4,64,3750,15999,'honor play.jpg');

INSERT INTO smartphone VALUES(DEFAULT,'mi a2','The Xiaomi Mi A2 is powered by octa-core (4x2.2GHz + 4x1.8GHz) processor and it comes with 6GB of RAM. The phone packs 128GB of internal storage that cannot be expanded. As far as the cameras are concerned, the Xiaomi Mi A2 packs a 12-megapixel (f/1.8, 1.25-micron) primary camera and a 20-megapixel (f/1.8, 1.0-micron) secondary camera on the rear and a 20-megapixel front shooter for selfies.','
Snapdragon 660','1080 x 2160',12,20,6,128,3010,16999,'mi a2.jpg');

INSERT INTO smartphone VALUES(DEFAULT,'v11 pro','12MP dual pixel+5MP primary dual camera ultra HD mode, ppt mode, professional mode, slow-mo, time-lapse photography, camera filter, live photo, bokeh mode, HDR mode, AI face beauty, panorama, palm capture, gender detection, retina flash, AR stickers, AI face shaping, time watermark, AI selfie lighting, AI scene recognition, google lens, AI portrait framing and 25MP front facing camera
16.29 centimeters (6.41-inch) super AMOLED FHD+ capacitive touchscreen with 2340 x 1080 pixels resolution, 403 ppi pixel density
Android v8.1 Oreo based on Funtouch 4.5 operating system with Qualcomm Snapdragon 660AIE octa core processor, 6GB RAM, 64GB internal memory expandable up to 256GB and dual SIM (nano+nano) dual-standby (4G+4G)
3400mAH lithium-ion battery with Dual-Engine fast charging','
Snapdragon 660','1080 x 2340',12,20,6,64,3400,25990,'v11 pro.jpg');

INSERT INTO smartphone VALUES(DEFAULT,
  'iphone 6s',
  'Apple iPhone 6s smartphone was launched in September 2015. The phone comes with a 4.70-inch touchscreen display with a resolution of 750 pixels by 1334 pixels at a PPI of 326 pixels per inch. The Apple iPhone 6s is powered by 1.84GHz dual-core processor and it comes with 2GB of RAM. The phone packs 16GB of internal storage that cannot be expanded. As far as the cameras are concerned, the Apple iPhone 6s packs a 12-megapixel (f/2.2, 1.22-micron) primary camera on the rear and a 5-megapixel front shooter for selfies.
  The Apple iPhone 6s is powered by a 1715mAh non removable battery. It measures 138.30 x 67.10 x 7.10 (height x width x thickness) and weighs 143.00 grams.',
  '
  Apple a9',
  '750 x 1334',
  12,
  5,
  2,
  32,
  1715,
  25990,
  'iphone 6s.jpg'
);



INSERT INTO smartphone VALUES(DEFAULT,'honor 10','The Honor 10 is here to give you a complete smartphone performance that will leave you awestruck every time you use it. With superior features such as a 24 MP AI Camera, AI Powered by Independent Neural Processing Unit (NPU), and more, that lets you take almost professional-like photos everywhere you go.','
Kirin 970','1080 x 2280',16,24,6,64,3400,33999,'honor 10.jpg');


INSERT INTO smartphone VALUES(DEFAULT,'oppo a3s','Experience multitasking at its best with the Oppo A3s. Featuring a blend of utility and style, the Oppo A3s comes with 3 GB of RAM, 32 GB of ROM, a 15.75-cm (6.2) HD+ display, and a massive 4230 mAh battery. With an elegant design, an enhanced UI and awesome features, the Oppo A3s is sure to sweep you off your feet.','
Snapdragon 450','720 x 1520',13,8,3,32,4230,10990,'oppo a3s.jpg');

INSERT INTO smartphone VALUES(DEFAULT,'oppo f9 pro','Oppo F9 Pro is the newest smartphone by the leading brand Oppo. Due to its attention-grabbing and sleek 6.3-inch Full HD display, and loaded with a powerful camera, this latest smartphone in India will fall under the bracket of premium phones. Unlike its predecessors, Oppo F9 Pro comes with a great internal storage, and boast a rear-mounted fingerprint sensor and a unique face unlock trait.','
Helio P60','2340 x 1080',16,25,6,64,3500,21990,'f9 pro.jpg');

INSERT INTO smartphone VALUES(DEFAULT,'iphone xs','iPhone Xs is in tune with earlier versions of Apple mobile phones with built in privacy and security. iPhone XS features an indulgent 14.73 cm (5.8) Super Retina Display, is sleek in appearance and constructed to be sturdy, delivering both in terms of aesthetics and durability. It is even resistant to liquid spills and dust. The A12 Bionic Chip which powers this Apple phone transforms the way you look at pictures, the way you game, or even the way you browse the internet on your phone. Explore different ways to capture the world around you with the iPhone Xs 12 MP dual-rear camera system and its 7 MP selfie camera.',
'A12 Bionic','2436 x 1125',12,7,4,64,2658,97900,'iphone xs.jpg');

INSERT INTO smartphone VALUES(DEFAULT,'Mi mix 3','Xiaomi Mi Mix 3 is a stylish phone with a sliding camera and a notch less display. The phone has a screen-to-body ratio of 93.4%, and cuts down on the “chin” at the bottom of the display. It has a 6.4-inch OLED 1080p panel. The device has 12 MP wide-angle and telephoto modules on the back, and a 24 MP selfie camera backed by a 2MP sensor on the front. The phone has a slide out selfie camera. Under the hood, the Mi Mix 3 is powered by a Snapdragon 845 processor with 6GB of RAM and 128GB of storage. It will run on Android 9 Pie OS based MIUI 10.','
Snapdragon 845','2340 x 1080',24,12,6,128,3200,41000,'Mi mix 3.jpg');

SELECT sum(qty)
FROM relic_user,cart,cartitems
WHERE relic_user.uid = cart.uid AND
      cart.id = cartitems.id AND
      relic_user.uid = 3 AND
      cart.id = 25 AND
      cartitems.pid = 10;