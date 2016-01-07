<?php

namespace Opifer\CmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;
use Opifer\ContentBundle\Model\Content as BaseContent;

/**
 * Content
 *
 * @ORM\Table(name="content")
 * @ORM\Entity(repositoryClass="Opifer\CmsBundle\Repository\ContentRepository")
 * @Gedmo\TranslationEntity(class="Opifer\CmsBundle\Entity\Translation\ContentTranslation")
 * @JMS\ExclusionPolicy("all")
 */
class Content extends BaseContent
{
    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @JMS\Expose
     * @JMS\Groups({"detail", "list"})
     */
    protected $id;

    /**
     * @var boolean
     *
     * @JMS\Expose
     * @JMS\Groups({"detail", "list"})
     * @ORM\Column(name="active", type="boolean")
     */
    protected $active = true;

    /**
     * @var  integer
     *
     * @ORM\ManyToOne(targetEntity="FOS\UserBundle\Model\UserInterface", inversedBy="contents")
     */
    protected $author;

    /**
     * @var boolean
     *
     * @ORM\Column(name="indexable", type="boolean")
     */
    protected $indexable = true;

    /**
     * @var boolean
     *
     * @ORM\Column(name="searchable", type="boolean")
     */
    protected $searchable = true;

    /**
     * @var string
     *
     * @JMS\Expose
     * @JMS\Groups({"detail", "list"})
     * @Gedmo\Translatable
     * @ORM\Column(name="title", type="string", length=255)
     * @Assert\NotBlank()
     */
    protected $title;

    /**
     * @var string
     *
     * @JMS\Expose
     * @JMS\Groups({"detail", "list"})
     * @Gedmo\Translatable
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    protected $description;

    /**
     * @var string
     *
     * @JMS\Expose
     * @JMS\Groups({"detail"})
     * @ORM\Column(name="presentation", type="text", nullable=true)
     */
    protected $presentation;

    /**
     * @var string
     *
     * @JMS\Expose
     * @Gedmo\Slug(handlers={
     *      @Gedmo\SlugHandler(class="Opifer\ContentBundle\Handler\AliasHandler", options={
     *          @Gedmo\SlugHandlerOption(name="field", value="slug"),
     *          @Gedmo\SlugHandlerOption(name="separator", value="-")
     *      })
     * }, fields={"alias"}, unique_base="deletedAt")
     * @ORM\Column(name="alias", type="string", length=255, nullable=true)
     *
     */
    protected $alias;

    /**
     * @var string
     *
     * @JMS\Expose
     * @JMS\Groups({"detail", "list"})
     * @Gedmo\Slug(handlers={
     *      @Gedmo\SlugHandler(class="Opifer\ContentBundle\Handler\SlugHandler", options={
     *          @Gedmo\SlugHandlerOption(name="relationField", value="directory"),
     *          @Gedmo\SlugHandlerOption(name="relationSlugField", value="slug"),
     *          @Gedmo\SlugHandlerOption(name="separator", value="/"),
     *          @Gedmo\SlugHandlerOption(name="onSlugCompletion", value={"appendIndex"})
     *      })
     * }, fields={"title"}, unique_base="deletedAt")
     * @ORM\Column(name="slug", type="string", length=255)
     */
    protected $slug;

    /**
     * @ORM\ManyToOne(targetEntity="Site")
     * @ORM\JoinColumn(name="site_id", referencedColumnName="id")
     */
    private $site;

    /**
     * Created at
     *
     * @var \DateTime
     *
     * @JMS\Expose
     * @JMS\Groups({"detail", "list"})
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created_at", type="datetime")
     */
    protected $createdAt;

    /**
     * Updated at
     *
     * @var \DateTime
     *
     * @JMS\Expose
     * @JMS\Groups({"detail", "list"})
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updated_at", type="datetime")
     */
    protected $updatedAt;

    /**
     * @Gedmo\Locale
     */
    private $locale;

    /**
     * Set translatable locale
     *
     * @param string $locale
     */
    public function setTranslatableLocale($locale)
    {
        $this->locale = $locale;
    }

    /**
     * Sets an author on for the content
     *
     * @var     User $author
     *
     * @return Content
     */
    public function setAuthor(User $author = null)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return User
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set site
     *
     * @param Site $site
     *
     * @return Content
     */
    public function setSite(Site $site = null)
    {
        $this->site = $site;

        return $this;
    }

    /**
     * Get site
     *
     * @return \Opifer\CmsBundle\Entity\Site
     */
    public function getSite()
    {
        return $this->site;
    }

    /**
     * Is content item public?
     *
     * @return boolean
     */
    public function isPublic()
    {
        return (is_null($this->nestedIn)) ? true : false;
    }

    /**
     * Is content item private?
     *
     * @return boolean
     */
    public function isPrivate()
    {
        return (!is_null($this->nestedIn)) ? true : false;
    }

    /**
     * Set indexable
     *
     * @param boolean $indexable
     *
     * @return Content
     */
    public function setIndexable($indexable)
    {
        $this->indexable = $indexable;

        return $this;
    }

    /**
     * Get indexable
     *
     * @return boolean
     */
    public function getIndexable()
    {
        return $this->indexable;
    }

    /**
     * Is indexable
     *
     * @return boolean
     */
    public function isIndexable()
    {
        return ($this->indexable) ? true : false;
    }

    /**
     * Set searchable
     *
     * @param  boolean $searchable
     * @return Content
     */
    public function setSearchable($searchable)
    {
        $this->searchable = $searchable;

        return $this;
    }

    /**
     * Get searchable
     *
     * @return boolean
     */
    public function getSearchable()
    {
        return $this->searchable;
    }

    /**
     * Is searchable
     *
     * @return boolean
     */
    public function isSearchable()
    {
        return ($this->searchable) ? true : false;
    }

    /**
     * @todo clean this mess up
     *
     * Finds first available image for listing purposes
     *
     * @return string
     */
    public function getCoverImage()
    {
        foreach ($this->getValueSet()->getValues() as $value) {
            switch (get_class($value)) {
                case 'Opifer\EavBundle\Entity\NestedValue':
                    foreach ($value->getNested() as $nested) {
                        if (false !== $cv = $nested->getCoverImage()) {
                            return $cv;
                        }
                    }
                    break;
                case 'Opifer\EavBundle\Entity\MediaValue':
                    foreach ($value->getMedias() as $media) {
                        return $media->getReference();
                        break;
                    }
                    break;
            }
        }

        return false;
    }

    /**
     * @todo clean this mess up
     *
     * Gets the attributes and places them in an (by Twig) easily accessible array
     *
     * @JMS\VirtualProperty
     * @JMS\SerializedName("attributes")
     * @JMS\Groups({"detail"})
     * @JMS\MaxDepth(2)
     *
     * @return array
     */
    public function getPivotedAttributes()
    {
        $array = [];
        foreach ($this->getValueSet()->getValues() as $value) {
            switch (get_class($value)) {
                case 'Opifer\EavBundle\Entity\CheckListValue':
                    $array[$value->getAttribute()->getName()] = array();
                    foreach ($value->getOptions() as $option) {
                        $array[$value->getAttribute()->getName()][] = [
                            'id' => $option->getId(),
                            'name' => $option->getName(),
                        ];
                    }
                    break;
                case 'Opifer\EavBundle\Entity\MediaValue':
                    $array[$value->getAttribute()->getName()] = array();
                    foreach ($value->getMedias() as $media) {
                        $array[$value->getAttribute()->getName()][] = [
                            'name' => $media->getName(),
                            'file' => $media->getFile(),
                        ];
                    }
                    break;
                default:
                    $array[$value->getAttribute()->getName()] = $value->getValue();
            }
        }

        return $array;
    }

    /**
     * Set defaults for nested content
     *
     * @return Content
     */
    public function setNestedDefaults()
    {
        $this->searchable = false;
        $this->indexable = false;

        return $this;
    }
}