package pt.ipleiria.estg.dei.psi.projeto.reparatech.adapters.homepage;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.ImageView;
import android.widget.TextView;

import com.bumptech.glide.Glide;
import com.bumptech.glide.load.engine.DiskCacheStrategy;

import java.util.ArrayList;

import pt.ipleiria.estg.dei.psi.projeto.reparatech.R;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.BestSellingProduct;

public class BestSellingProductAdapter extends BaseAdapter {

    private Context context;
    private LayoutInflater inflater;
    private ArrayList<BestSellingProduct> bestSellingProducts;

    public BestSellingProductAdapter(Context context, ArrayList<BestSellingProduct> bestSellingProducts) {
        this.context = context;
        this.bestSellingProducts = bestSellingProducts;
    }

    @Override
    public int getCount() {
        return bestSellingProducts.size();
    }

    @Override
    public Object getItem(int i) {
        return bestSellingProducts.get(i);
    }

    @Override
    public long getItemId(int i) {
        return bestSellingProducts.get(i).getId();
    }

    @Override
    public View getView(int i, View view, ViewGroup viewGroup) {

        if (inflater == null){
            inflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
        }
        if (view == null){
            view = inflater.inflate(R.layout.item_best_selling_product, null);
        }
        ViewHolderList viewHolderList = (ViewHolderList) view.getTag();
        if(viewHolderList == null){
            viewHolderList = new ViewHolderList(view);
            view.setTag(viewHolderList);
        }

        viewHolderList.update(bestSellingProducts.get(i));
        return view;
    }

    private class ViewHolderList {
        private TextView tvBestSellingProductName,tvBestSellingProductPrice;
        private ImageView imgBestSellingProduct;
        public ViewHolderList(View view){
            tvBestSellingProductName = view.findViewById(R.id.tvBestSellingProductName);
            tvBestSellingProductPrice = view.findViewById(R.id.tvBestSellingProductPrice);
            imgBestSellingProduct = view.findViewById(R.id.imgBestSellingProduct);
        }
        public void update(BestSellingProduct bestSellingProduct){
            tvBestSellingProductName.setText(bestSellingProduct.getName());
            tvBestSellingProductPrice.setText(bestSellingProduct.getPrice() + " €");
            Glide.with(context)
                    .load(bestSellingProduct.getImage())
                    .diskCacheStrategy(DiskCacheStrategy.ALL)
                    .into(imgBestSellingProduct);
        }
    }
}
