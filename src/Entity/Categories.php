<?php

namespace App\Entity;

use App\Repository\CategoriesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoriesRepository::class)]
class Categories
{

  public function __toString()
  {
      return $this->name;
//ou return $this->firstname;
//ça dépend au nommation de nos variable
//ou       return $this->firstname." ". $this->lastname;

  }
  #[ORM\Id]
  #[ORM\GeneratedValue]
  #[ORM\Column]
  private ?int $id = null;

  #[ORM\Column(length: 255)]
  private ?string $name = null;

  #[ORM\Column]
  private ?string $categoryOrder = null;

  #[ORM\Column(type: 'string', length: 65)]
  private $slug;

  public function getSlug(): ?string
  {
    return $this->slug;
  }

  public function setSlug(string $slug): self
  {
    $this->slug = $slug;

    return $this;
  }

  #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'categories')]
  #[ORM\JoinColumn(onDelete: 'CASCADE')]
  private ?self $parent = null;

  #[ORM\OneToMany(mappedBy: 'parent', targetEntity: self::class)]
  private Collection $categories;

  #[ORM\OneToMany(mappedBy: 'categories', targetEntity: Products::class)]
  private Collection $products;

  public function __construct()
  {
    $this->categories = new ArrayCollection();
    $this->products = new ArrayCollection();
  }

  public function getId(): ?int
  {
    return $this->id;
  }

  public function getName(): ?string
  {
    return $this->name;
  }

  public function setName(string $name): self
  {
    $this->name = $name;

    return $this;
  }

  public function getCategoryOrder(): ?int
  {
    return $this->categoryOrder;
  }

  public function setCategoryOrder(int $categoryOrder): self
  {
    $this->categoryOrder = $categoryOrder;

    return $this;
  }

  public function getParent(): ?self
  {
    return $this->parent;
  }

  public function setParent(?self $parent): self
  {
    $this->parent = $parent;

    return $this;
  }

  /**
   * @return Collection<int, self>
   */
  public function getCategories(): Collection
  {
    return $this->categories;
  }

  public function addCategory(self $category): self
  {
    if (!$this->categories->contains($category)) {
      $this->categories->add($category);
      $category->setParent($this);
    }

    return $this;
  }

  public function removeCategory(self $category): self
  {
    if ($this->categories->removeElement($category)) {
      // set the owning side to null (unless already changed)
      if ($category->getParent() === $this) {
        $category->setParent(null);
      }
    }

    return $this;
  }

  /**
   * @return Collection<int, Products>
   */
  public function getProducts(): Collection
  {
    return $this->products;
  }

  public function addProduct(Products $product): self
  {
    if (!$this->products->contains($product)) {
      $this->products->add($product);
      $product->setCategories($this);
    }

    return $this;
  }

  public function removeProduct(Products $product): self
  {
    if ($this->products->removeElement($product)) {
      // set the owning side to null (unless already changed)
      if ($product->getCategories() === $this) {
        $product->setCategories(null);
      }
    }

    return $this;
  }
}
