package pt.ipleiria.estg.dei.psi.projeto.reparatech.models;

import java.util.ArrayList;

import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.SaleProduct;

public class Order {
    private int id;
    private int clientId;
    private String createdAt;
    private String status;
    private String address;
    private String zipCode;
    private ArrayList<SaleProduct> saleProducts;
    private String invoice;

    public Order(int id, int clientId, String createdAt, String status, String address,
                 String zipCode, String invoice, ArrayList<SaleProduct> saleProducts) {
        this.id = id;
        this.clientId = clientId;
        this.createdAt = createdAt;
        this.status = status;
        this.address = address;
        this.zipCode = zipCode;
        this.invoice = invoice;
        this.saleProducts = saleProducts;
    }

    // Getters and setters
    public int getId() { return id; }
    public void setId(int id) { this.id = id; }
    public int getClientId() { return clientId; }
    public void setClientId(int clientId) { this.clientId = clientId; }
    public String getCreatedAt() { return createdAt; }
    public void setCreatedAt(String createdAt) { this.createdAt = createdAt; }
    public String getStatus() { return status; }
    public void setStatus(String status) { this.status = status; }
    public String getAddress() { return address; }
    public void setAddress(String address) { this.address = address; }
    public String getZipCode() { return zipCode; }
    public void setZipCode(String zipCode) { this.zipCode = zipCode; }
    public ArrayList<SaleProduct> getSaleProducts() { return saleProducts; }
    public void setSaleProducts(ArrayList<SaleProduct> saleProducts) { this.saleProducts = saleProducts; }
    public String getInvoice() { return invoice; }
    public void setInvoice(String invoice) { this.invoice = invoice; }
}
