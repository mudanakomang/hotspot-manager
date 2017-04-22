#bin/bash/
ssh root@10.10.1.4 "echo "User-Name=100,Framed-IP-Address=10.10.6.172" | radclient -x 10.10.1.1:3799 disconnect testing123"
