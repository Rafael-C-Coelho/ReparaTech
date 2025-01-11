package pt.ipleiria.estg.dei.psi.projeto.reparatech;

import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.HorizontalScrollView;
import android.widget.LinearLayout;

import androidx.fragment.app.Fragment;

import java.util.ArrayList;

import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.BestSellingProduct;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.RepairExample;


public class EmployeeHomepageFragment extends Fragment {

    private HorizontalScrollView hScrollViewRepairCategories;
    private HorizontalScrollView hScrollBestSellingProducts;
    private ArrayList<RepairExample> repairExamples;
    private ArrayList<BestSellingProduct> bestSellingProducts;
    private RepairExample repairExample;



    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.fragment_employee_homepage, container, false);
        

        // repairExamples = ReparaTechSingleton.getInstance(getContext()).getRepairExamples();
        //bestSellingProducts = ReparaTechSingleton.getInstance(getContext()).getbestSellingProductsExamples();
        /*
        for (RepairExample repairExample: repairExamples) {
            View cardView = inflater.inflate(R.layout.item_repaircategorie_homepage,gallery,false);

            ImageView imgCapa = cardView.findViewById(R.id.imgCapa);
            TextView tvBrokenScreen = cardView.findViewById(R.id.tvBrokenScreen);
            imgCapa.setImageResource(repairExample.getImg());
            tvBrokenScreen.setText(repairExample.getTitle());


            gallery.addView(cardView);

            cardView.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View view) {
                    if (repairExample.getId() == -1) {
                        Intent intent = new Intent(getActivity(), RepairCategoriesListActivity.class);
                        startActivity(intent);
                    }
                }
            });
        }
        */


        /*
        for (BestSellingProduct bestSellingProduct: bestSellingProducts) {
            View cardView = inflater.inflate(R.layout.item_bestselling_product,llBestSellingProducts,false);

            ImageView imgBestSellingProduct = cardView.findViewById(R.id.imgBestSellingProduct);
            TextView tvBestSellingProductName = cardView.findViewById(R.id.tvBestSellingProductName);
            TextView tvBestSellingProductPrice = cardView.findViewById(R.id.tvBestSellingProductPrice);

            imgBestSellingProduct.setImageResource(bestSellingProduct.getImg());
            tvBestSellingProductName.setText(bestSellingProduct.getTitle());
            //tvBestSellingProductPrice.setText(" €" + bestSellingProduct.getPrice()); //conversão do preço para string

            llBestSellingProducts.addView(cardView);

        }
   
         */

        return view;
    }
}