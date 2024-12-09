package pt.ipleiria.estg.dei.psi.projeto.reparatech.models;

public class RepairCategoryDetail {

    private int id;
    private String mobile, tablet, desktop, wearable, cost, duration;


    public RepairCategoryDetail(int id, String mobile, String tablet, String desktop, String wearable, String cost, String duration) {
        this.id = id;
        this.mobile = mobile;
        this.tablet = tablet;
        this.desktop = desktop;
        this.wearable = wearable;
        this.cost = cost;
        this.duration = duration;
    }

    public int getId() {
        return id;
    }

    public String getMobile() {
        return mobile;
    }

    public String getTablet() {
        return tablet;
    }

    public String getDesktop() {
        return desktop;
    }

    public String getWearable() {
        return wearable;
    }

    public String getCost() {
        return cost;
    }

    public String getDuration() {
        return duration;
    }


    public void setMobile(String mobile) {
        this.mobile = mobile;
    }

    public void setTablet(String tablet) {
        this.tablet = tablet;
    }

    public void setDesktop(String desktop) {
        this.desktop = desktop;
    }

    public void setWearable(String wearable) {
        this.wearable = wearable;
    }

    public void setCost(String cost) {
        this.cost = cost;
    }

    public void setDuration(String duration) {
        this.duration = duration;
    }
}
