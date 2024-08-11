using AutoMapper;
using ddApp.Dto;
using ddApp.Interfaces;
using ddApp.Models;
using Microsoft.AspNetCore.Mvc;
using System.Collections.Generic;

namespace ddApp.Controllers
{
    [Route("api/[controller]")]
    [ApiController]
    public class PreOrderController : ControllerBase
    {
        private readonly IPreOrderRepository _preOrderRepository;
        private readonly IMapper _mapper;

        public PreOrderController(IPreOrderRepository preOrderRepository, IMapper mapper)
        {
            _preOrderRepository = preOrderRepository;
            _mapper = mapper;
        }

        [HttpGet]
        [ProducesResponseType(200, Type = typeof(IEnumerable<PreOrderDto>))]
        public IActionResult GetPreOrders()
        {
            var preOrders = _mapper.Map<List<PreOrderDto>>(_preOrderRepository.GetPreOrders());

            if (!ModelState.IsValid)
            {
                return BadRequest(ModelState);
            }

            return Ok(preOrders);
        }

        [HttpGet("{preOrderId}")]
        [ProducesResponseType(200, Type = typeof(PreOrderDto))]
        [ProducesResponseType(400)]
        public IActionResult GetPreOrder(int preOrderId)
        {
            if (!_preOrderRepository.PreOrderExists(preOrderId))
                return NotFound();

            var preOrder = _mapper.Map<PreOrderDto>(_preOrderRepository.GetPreOrder(preOrderId));

            if (!ModelState.IsValid)
            {
                return BadRequest(ModelState);
            }

            return Ok(preOrder);
        }

        [HttpPost]
        [ProducesResponseType(204)]
        [ProducesResponseType(400)]
        public IActionResult CreatePreOrder([FromBody] PreOrderDto preOrderCreate)
        {
            if (preOrderCreate == null)
                return BadRequest(ModelState);

            var preOrderMap = _mapper.Map<PreOrder>(preOrderCreate);

            if (!_preOrderRepository.CreatePreOrder(preOrderMap))
            {
                ModelState.AddModelError("", "Something went wrong while saving");
                return StatusCode(500, ModelState);
            }

            return Ok("Successfully created");
        }

        [HttpPut("{preOrderId}")]
        [ProducesResponseType(204)]
        [ProducesResponseType(400)]
        public IActionResult UpdatePreOrder(int preOrderId, [FromBody] PreOrderDto updatedPreOrder)
        {
            if (updatedPreOrder == null || preOrderId != updatedPreOrder.PreOrderID)
                return BadRequest(ModelState);

            if (!_preOrderRepository.PreOrderExists(preOrderId))
                return NotFound();

            var preOrderMap = _mapper.Map<PreOrder>(updatedPreOrder);

            if (!_preOrderRepository.UpdatePreOrder(preOrderMap))
            {
                ModelState.AddModelError("", "Something went wrong while updating");
                return StatusCode(500, ModelState);
            }

            return NoContent();
        }

        [HttpDelete("{preOrderId}")]
        [ProducesResponseType(204)]
        [ProducesResponseType(400)]
        public IActionResult DeletePreOrder(int preOrderId)
        {
            if (!_preOrderRepository.PreOrderExists(preOrderId))
                return NotFound();

            var preOrder = _preOrderRepository.GetPreOrder(preOrderId);

            if (!_preOrderRepository.DeletePreOrder(preOrder))
            {
                ModelState.AddModelError("", "Something went wrong while deleting");
                return StatusCode(500, ModelState);
            }

            return NoContent();
        }
    }
}