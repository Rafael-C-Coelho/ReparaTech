package pt.ipleiria.estg.dei.psi.projeto.reparatech.models;

public class OrderDisplay {
    private int id;
    private String status;
    private double totalOrder;
    private String productNames;
    private int totalQuantity;

    public OrderDisplay(int id, String status, double totalOrder, String productNames, int totalQuantity) {
        this.id = id;
        this.status = status;
        this.totalOrder = totalOrder;
        this.productNames = productNames;
        this.totalQuantity = totalQuantity;
    }

    public int getId() {
        return id;
    }

    public String getStatus() {
        return status;
    }

    public void setStatus(String status) {
        this.status = status;
    }

    public double getTotalOrder() {
        return totalOrder;
    }

    public void setTotalOrder(double totalOrder) {
        this.totalOrder = totalOrder;
    }

    public String getProductNames() {
        return productNames;
    }

    public void setProductNames(String productNames) {
        this.productNames = productNames;
    }

    public int getTotalQuantity() {
        return totalQuantity;
    }

    public void setTotalQuantity(int totalQuantity) {
        this.totalQuantity = totalQuantity;
    }
}
