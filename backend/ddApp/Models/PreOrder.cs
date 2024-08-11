namespace ddApp.Models
{
    public class PreOrder
    {
        public int PreOrderID { get; set; }
        public int CustomerID { get; set; } 
        public int ProductID { get; set; } 
        public int Quantity { get; set; }
        public DateTime PreOrderDate { get; set; }
        public bool IsFulfilled { get; set; }

        
        public Customer Customer { get; set; }
        public Product Product { get; set; }
    }
}
