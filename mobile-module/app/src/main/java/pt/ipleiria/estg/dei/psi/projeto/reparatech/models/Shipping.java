package pt.ipleiria.estg.dei.psi.projeto.reparatech.models;

public class Shipping {
    private String address, zipcode;

    public String getAddress() {
        return address;
    }

    public void setAddress(String address) {
        this.address = address;
    }

    public String getZipcode() {
        return zipcode;
    }

    public void setZipcode(String zipcode) {
        this.zipcode = zipcode;
    }

    public Shipping() {
    }

    public Shipping(String address, String zipcode) {
        this.address = address;
        this.zipcode = zipcode;
    }
}
