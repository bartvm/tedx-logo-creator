<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
  <xsl:output method="xml" indent="yes" />
  <xsl:template match="@* | node()">
    <xsl:copy>
    	<xsl:apply-templates select="@* | node()" />
  	</xsl:copy>
	</xsl:template>
  <xsl:template match="@fill">
    <xsl:choose>
      <xsl:when test=". = '#FFFFFF'">
        <xsl:attribute name="fill">
        	<xsl:text>#000000</xsl:text>
      	</xsl:attribute>
			</xsl:when>
			<xsl:otherwise>
        <xsl:attribute name="fill">
          <xsl:value-of select="." />
        </xsl:attribute>
			</xsl:otherwise>
		</xsl:choose>
	</xsl:template>
</xsl:stylesheet>