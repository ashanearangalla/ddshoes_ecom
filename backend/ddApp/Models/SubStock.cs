namespace ddApp.Models
{
    public class SubStock
    {
        public int SubStockID { get; set; }
        public int ProductID { get; set; } 
        public int UserID { get; set; } 
        public int Quantity { get; set; } 
        public int Sold { get; set; } 
        public int Remaining => Quantity - Sold; 


        public Product Product { get; set; }
        public User User { get; set; }

        public ICollection<Sale> Sales { get; set; }
    }
}