#!/bin/bash
​
​
for REGION in $(aws lightsail get-regions --query "regions[*].{name:name}" --output text)
do
    echo ${REGION}
	aws ec2 describe-instances --region ${REGION} --output table --filters 'Name=tag:Name,Values=*vpn*' --query 'Reservations[*].Instances[*].{ Name:Tags[?Key == `Name`] | [0].Value, Instance:InstanceId, IPAddress:PublicIpAddress}'
done