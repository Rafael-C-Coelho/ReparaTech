package pt.ipleiria.estg.dei.psi.projeto.reparatech.adapters.homepage;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.ImageView;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;

import com.bumptech.glide.Glide;
import com.bumptech.glide.load.engine.DiskCacheStrategy;

import java.util.ArrayList;

import pt.ipleiria.estg.dei.psi.projeto.reparatech.R;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.BestSellingProduct;

public class BestSellingProductAdapter extends RecyclerView.Adapter<BestSellingProductAdapter.ViewHolderList> {

    private Context context;
    private LayoutInflater inflater;
    private ArrayList<BestSellingProduct> bestSellingProducts;

    public BestSellingProductAdapter(Context context, ArrayList<BestSellingProduct> bestSellingProducts) {
        this.context = context;
        this.bestSellingProducts = bestSellingProducts;
    }

    @NonNull
    @Override
    public BestSellingProductAdapter.ViewHolderList onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        if (inflater == null) {
            inflater = LayoutInflater.from(parent.getContext());
        }
        View view = inflater.inflate(R.layout.item_best_selling_product, parent, false);
        return new ViewHolderList(view);
    }

    @Override
    public void onBindViewHolder(@NonNull BestSellingProductAdapter.ViewHolderList holder, int position) {
        BestSellingProduct bestSellingProduct = bestSellingProducts.get(position);
        holder.update(bestSellingProduct);
    }

    @Override
    public int getItemCount() {
        return bestSellingProducts.size();
    }

    public class ViewHolderList extends RecyclerView.ViewHolder {
        private TextView tvBestSellingProductName,tvBestSellingProductPrice;
        private ImageView imgBestSellingProduct;
        public ViewHolderList(View view){
            super(view);
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
