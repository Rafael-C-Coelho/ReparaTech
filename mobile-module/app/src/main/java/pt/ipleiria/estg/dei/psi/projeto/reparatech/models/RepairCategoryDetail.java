package pt.ipleiria.estg.dei.psi.projeto.reparatech.models;

public class RepairCategoryDetail {

    private int id;
    public int image;
    public String mobile;
    public String tablet;
    private String desktop;
    private String wearable;


    public RepairCategoryDetail(int id, int image, String mobile, String tablet, String desktop, String wearable) {
        this.id = id;
        this.image = image;
        this.mobile = mobile;
        this.tablet = tablet;
        this.desktop = desktop;
        this.wearable = wearable;
    }


}
