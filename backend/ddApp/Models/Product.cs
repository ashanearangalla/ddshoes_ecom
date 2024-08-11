namespace ddApp.Models
{
    public class Product
    {
        public int ProductID { get; set; }
        public string ProductName { get; set; }
        public string Description { get; set; }
        public decimal Price { get; set; }
        public bool IsLocked { get; set; } 
        public string ImageUrl { get; set; } 

      
        public ICollection<OrderItem> OrderItems { get; set; }
        public ICollection<MainStock> MainStocks { get; set; }
        public ICollection<SubStock> SubStocks { get; set; }
        public ICollection<PreOrder> PreOrders { get; set; }
    }
}