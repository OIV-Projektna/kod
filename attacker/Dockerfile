FROM kalilinux/kali-rolling
RUN apt-get update && apt-get install -y \
    dsniff \
    ettercap-text-only \
    wireshark-common \
    tcpdump \
    curl \
    net-tools \
    iputils-ping \
    dnsutils \
    sslstrip \
    python3 \
    && rm -rf /var/lib/apt/lists/*
CMD ["/bin/bash"]