namespace ddApp.Dto
{
    public class PreOrderDto
    {
        public int PreOrderID { get; set; }
        public int CustomerID { get; set; } // Foreign key to Customer
        public int ProductID { get; set; } // Foreign key to Product
        public int Quantity { get; set; }
        public DateTime PreOrderDate { get; set; }
        public bool IsFulfilled { get; set; }
    }
}
