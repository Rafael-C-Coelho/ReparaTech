package pt.ipleiria.estg.dei.psi.projeto.reparatech;

import android.os.Bundle;

import androidx.fragment.app.Fragment;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.HorizontalScrollView;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.TextView;

import java.util.ArrayList;

import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.BestSellingProduct;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.RepairExample;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.ReparaTechSingleton.ReparaTechSingleton;


public class HomepageFragment extends Fragment {

    private HorizontalScrollView hScrollViewRepairCategories;
    private HorizontalScrollView hScrollBestSellingProducts;
    private ArrayList<RepairExample> repairExamples;
    private ArrayList<BestSellingProduct> bestSellingProducts;

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.fragment_homepage, container, false);

        LinearLayout gallery = view.findViewById(R.id.RepairCategories);
        LinearLayout llBestSellingProducts = view.findViewById(R.id.BestSellingProducts);


        hScrollViewRepairCategories = view.findViewById(R.id.hScrollViewRepairCategories);
        hScrollBestSellingProducts = view.findViewById(R.id.hScrollBestSellingProducts);
        repairExamples = ReparaTechSingleton.getInstance().getRepairExamples();
        bestSellingProducts = ReparaTechSingleton.getInstance().getbestSellingProductsExamples();

        for (RepairExample repairExample: repairExamples) {
            View cardView = inflater.inflate(R.layout.item_repair_example,gallery,false);

            ImageView imgCapa = cardView.findViewById(R.id.imgCapa);
            TextView tvBrokenScreen = cardView.findViewById(R.id.tvBrokenScreen);
            TextView tvPrice = cardView.findViewById(R.id.tvPrice);

            imgCapa.setImageResource(repairExample.getImg());
            tvBrokenScreen.setText(repairExample.getTitle());
            tvPrice.setText(repairExample.getPrice());

            gallery.addView(cardView);

        }

        for (BestSellingProduct bestSellingProduct: bestSellingProducts) {
            View cardView = inflater.inflate(R.layout.item_bestselling_product,llBestSellingProducts,false);

            ImageView imgBestSellingProduct = cardView.findViewById(R.id.imgBestSellingProduct);
            TextView tvBestSellingProductName = cardView.findViewById(R.id.tvBestSellingProductName);
            TextView tvBestSellingProductPrice = cardView.findViewById(R.id.tvBestSellingProductPrice);

            imgBestSellingProduct.setImageResource(bestSellingProduct.getImg());
            tvBestSellingProductName.setText(bestSellingProduct.getTitle());
            tvBestSellingProductPrice.setText(" €" + bestSellingProduct.getPrice()); //conversão do preço para string

            llBestSellingProducts.addView(cardView);

        }

        return view;
    }

}