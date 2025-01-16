package pt.ipleiria.estg.dei.psi.projeto.reparatech.adapters;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.TextView;

import java.util.ArrayList;

import pt.ipleiria.estg.dei.psi.projeto.reparatech.R;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.Order;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.Product;

public class OrderListAdapter extends BaseAdapter {

    private Context context;
    private LayoutInflater inflater;
    private ArrayList<Order> orders;

    public OrderListAdapter(Context context, ArrayList<Order> orders) {
        this.context = context;
        this.orders = orders;
    }


    @Override
    public int getCount() {
        return orders.size();
    }

    @Override
    public Object getItem(int position) {
        return orders.get(position);
    }

    @Override
    public long getItemId(int position) {
        return orders.get(position).getId();
    }

    @Override
    public View getView(int position, View convertView, ViewGroup parent) {
        if(inflater == null){
            inflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
        }

        if(convertView == null){
            convertView = inflater.inflate(R.layout.item_list_order, null);
        }

        OrderListAdapter.ViewHolderOrder viewHolderList = (OrderListAdapter.ViewHolderOrder) convertView.getTag();
        if(viewHolderList == null){
            viewHolderList = new OrderListAdapter.ViewHolderOrder(convertView);
            convertView.setTag(viewHolderList);
        }

        viewHolderList.update(orders.get(position));

        return convertView;
    }

    private class ViewHolderOrder {
        private TextView tvId;
        private TextView tvStatus;
        private TextView tvTotalOrder;
        private TextView tvProducts;
        private TextView tvProductQuantity;

        public ViewHolderOrder(View view) {
            tvId = view.findViewById(R.id.tvId);
            tvStatus = view.findViewById(R.id.tvStatus);
            tvTotalOrder = view.findViewById(R.id.tvTotalOrder);
            tvProducts = view.findViewById(R.id.tvProducts);
            tvProductQuantity = view.findViewById(R.id.tvProductQuantity);
        }

        public void update(Order order) {
            tvId.setText(order.getId());
            tvStatus.setText(order.getStatus());
            tvTotalOrder.setText("" + order.getTotalOrder());
            tvProducts.setText(order.getProducts().toString());
            tvProductQuantity.setText("" + order.getProductQuantity());

            StringBuilder productsInfo = new StringBuilder();
            for (Product product : order.getProducts()) {
                productsInfo.append(product.getName()).append("\n");
            }
            tvProducts.setText(productsInfo.toString().trim());
        }
        public void update(Product product) {
            tvId.setText(product.getId());
            tvStatus.setText("");
            tvTotalOrder.setText("");
            tvProducts.setText(product.getName());
            tvProductQuantity.setText("");
        }
    }
}
