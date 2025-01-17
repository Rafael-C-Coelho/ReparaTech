package pt.ipleiria.estg.dei.psi.projeto.reparatech.listeners;

import java.util.ArrayList;

import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.BestSellingProduct;

public interface BestSellingProductListener {
    void onProductsFetched(ArrayList<BestSellingProduct> products);
}
