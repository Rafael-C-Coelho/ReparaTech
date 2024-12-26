package pt.ipleiria.estg.dei.psi.projeto.reparatech.models;

public class RepairCategoryDetail {
    public static final String ID_CATEGORIES_LIST = "id_categories_list";
    private int idCategory;
    private String mobile_solution, tablet_solution, desktop_laptop_solution, wearable_solution;

    public RepairCategoryDetail(int idCategory, String mobile_solution, String tablet_solution, String desktop_laptop_solution, String wearable_solution) {
        this.idCategory = idCategory;
        this.mobile_solution = mobile_solution;
        this.tablet_solution = tablet_solution;
        this.desktop_laptop_solution = desktop_laptop_solution;
        this.wearable_solution = wearable_solution;
    }

    public int getIdCategory() {
        return idCategory;
    }

    public String getMobile_solution() {
        return mobile_solution;
    }

    public String getTablet_solution() {
        return tablet_solution;
    }

    public String getDesktop_laptop_solution() {
        return desktop_laptop_solution;
    }

    public String getWearable_solution() {
        return wearable_solution;
    }

}
