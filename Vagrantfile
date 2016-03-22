Vagrant.configure("2") do |config|
  config.hostmanager.enabled      = true
  config.hostmanager.manage_host  = true

  # configure 2GB (2048MB) of memory
  config.vm.provider :virtualbox do |vb|
    vb.customize ["modifyvm", :id, "--memory", 2048]
    vb.customize ["modifyvm", :id, "--natdnshostresolver1", "on"]
  end

  config.vm.provider :vmware_fusion do |vw|
    vw.vmx["memsize"] = "2048"
  end

  # Vagrant box config (Ubuntu 14.04 LTS)
  config.vm.box	      = "ubuntu/trusty64"
  config.vm.hostname  = "classcentral"

  config.hostmanager.aliases = %w(classcentral.dev)

  # Dedicated IP to avoid conflicts (and no port fowarding!)
  config.vm.network :private_network, ip: "33.33.33.20"

  # Remount the default shared folder as NFS for caching & speed
  config.vm.synced_folder ".", "/vagrant", :nfs => true

  # Mount local SSH keys for deployments
  # config.vm.synced_folder "~/.ssh", "/home/vagrant/.ssh"

  # Setup basic provisioning
  config.vm.provision :shell, :path => "./bin/provision.sh"

  # Setup Git
  gitconfig = `cat ~/.gitconfig`
  config.vm.provision :shell do |shell|
    shell.inline = "cat > /home/vagrant/.gitconfig << CONFIG\n#{gitconfig}\nCONFIG\n"
  end
end
