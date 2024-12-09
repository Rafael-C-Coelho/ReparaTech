package pt.ipleiria.estg.dei.psi.projeto.reparatech.ReparaTechSingleton;

import java.util.ArrayList;

import pt.ipleiria.estg.dei.psi.projeto.reparatech.R;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.BestSellingProduct;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.Product;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.RepairCategory;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.RepairExample;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.Settings;

public class ReparaTechSingleton {
    private ArrayList<BestSellingProduct> bestSellingProducts;
    private ArrayList<RepairCategory> repairCategories;
    private ArrayList<Product> products;
    private static ReparaTechSingleton instance = null;


    private ReparaTechSingleton(){
        generateDinamicRepairCategories();
        generateDinamicBestSellingProducts();
        generateDinamicProducts();
    }

    public static synchronized ReparaTechSingleton getInstance() {
        if(instance==null) {
            instance = new ReparaTechSingleton();
        }
        return instance;
    }

    public ArrayList<RepairExample> getRepairExamples(){
        ArrayList<RepairExample> repairExamples = new ArrayList<>();
        for (int i = 1; i <= 8; i++) {
            repairExamples.add(new RepairExample(
                repairCategories.get(i - 1).getId(),
                repairCategories.get(i - 1).getTitle(),
                repairCategories.get(i - 1).getImg()
            ));
        }
        repairExamples.add(new RepairExample(-1,"VIEW ALL",R.drawable.repairs));
        return repairExamples;
    }

    private void generateDinamicBestSellingProducts() {
        bestSellingProducts = new ArrayList<>();
        bestSellingProducts.add(new BestSellingProduct(1,"Capa Iphone",20, R.drawable.iphone_capa));
        bestSellingProducts.add(new BestSellingProduct(2,"Cabo USB-C",10, R.drawable.iphone_capa));
        bestSellingProducts.add(new BestSellingProduct(3,"Película de Ecrã Iphone 13",12, R.drawable.iphone_capa));
        bestSellingProducts.add(new BestSellingProduct(4,"Película de Ecrã Xiaomi Redmi Note 13",12, R.drawable.iphone_capa));
        bestSellingProducts.add(new BestSellingProduct(5,"Mochila ASUS para Laptop ",55, R.drawable.iphone_capa));
        bestSellingProducts.add(new BestSellingProduct(6,"Rato Ergonómico Logitech",85, R.drawable.iphone_capa));
    }

    private void generateDinamicRepairCategories(){
        repairCategories = new ArrayList<>();
        repairCategories.add(new RepairCategory(1,"Audio Issues",
                "If your device does not transmit sounds, our team is ready to solve the problem with maximum efficiency and quality.",
                R.drawable.iphone_capa));
        repairCategories.add(new RepairCategory(2,"Battery Issues",
                "If your device has battery damaged, our team is ready to solve the problem with maximum efficiency and quality.",
                R.drawable.iphone_capa));
        repairCategories.add(new RepairCategory(3,"Buttons Issues",
                "If your device has some button damaged, our team is ready to solve the problem with maximum efficiency and quality.",
                R.drawable.iphone_capa));
        repairCategories.add(new RepairCategory(4,"Broken Screen",
                "If your device has a damaged screen, our team is ready to solve the problem with maximum efficiency and quality.\".",
                R.drawable.iphone_capa));
        repairCategories.add(new RepairCategory(5,"Camera Issues",
                "If your device has camera damaged, our team is ready to solve the problem with maximum efficiency and quality.",
                R.drawable.iphone_capa));
        repairCategories.add(new RepairCategory(6,"Connectivity Issues",
                "If your device has connectivity issues, our team is ready to solve the problem with maximum efficiency and quality.",
                R.drawable.iphone_capa));
        repairCategories.add(new RepairCategory(7,"Data Recovery",
                "Have you lost important data that you'd like to recover? Our team is ready to solve the problem with maximum efficiency and quality.",
                R.drawable.iphone_capa));
        repairCategories.add(new RepairCategory(8,"Hardware Cleaning",
                "Do you want to carry out routine maintenance or clean the internal components of your device? Our team is ready to do it with maximum efficiency and quality.",
                R.drawable.iphone_capa));
        repairCategories.add(new RepairCategory(9,"Liquid Damage",
                "Has your device fallen into the pool and won't switch on? Our team is ready to solve the problem with maximum efficiency and quality.",
                R.drawable.iphone_capa));
        repairCategories.add(new RepairCategory(10,"Network Issues",
                "If your device has network issues, our team is ready to solve the problem with maximum efficiency and quality.",
                R.drawable.iphone_capa));
        repairCategories.add(new RepairCategory(11,"Software Issues",
                "If your device has malicious software, our team is ready to solve the problem with the utmost efficiency and quality.",
                R.drawable.iphone_capa));
        repairCategories.add(new RepairCategory(12,"Storage Issues",
                "If your device has storage issues, our team is ready to solve the problem with maximum efficiency and quality.",
                R.drawable.iphone_capa));
    }



    private void generateDinamicProducts(){
        products = new ArrayList<>();
        products.add(new Product(1, "Capa Iphone", "Capa para Iphone", 10, R.drawable.iphone_capa));
        products.add(new Product(2, "Capa Samsung", "Capa para Samsung", 10, R.drawable.iphone_capa));
    }

    public ArrayList<BestSellingProduct> getbestSellingProductsExamples() {
        return new ArrayList<>(bestSellingProducts);
    }

    public ArrayList<RepairCategory> getRepairCategories(){
        return new ArrayList<>(repairCategories);
    }


    public RepairCategory getRepairCategory(int id){
        for (RepairCategory l:repairCategories){
            if (l.getId() == id) {
                return l;
            }
        }
        return null;
    }

    public ArrayList<Product> getProducts(){
        return new ArrayList<>(products);
    }



}
